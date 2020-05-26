<?php

namespace App\Controller;

use App\Entity\Driver;
use App\Entity\Order;
use App\Entity\User;
use App\Enum\OrderStatusEnum;
use App\Form\DriverType;
use App\Repository\DriverRepository;
use App\Repository\OrderRepository;
use App\Service\EntityRadarService;
use App\Service\NotificationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\Publisher;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/driver")
 */
class DriverController extends AbstractController
{

    /**
     * @Route("/pending", name="driver_pending_orders", methods={"GET"})
     */
    public function pendingOrderIndex(Request $request, OrderRepository $orderRepository, EntityRadarService $entityRadarService): Response
    {

        /** @var User $user */
        $user = $this->getUser();
        $driver = $user->getDriver();



        $orders = [];

        if ($driver->getIsWorking()) {


            $orders = $entityRadarService->getNearbyEntities([54.924293, 23.943115], Order::class, 'latCoordinateStart', 'lngCoordinateStart');


            $orders = array_filter($orders, function(Order $order) {
                return $order->getStatus() == OrderStatusEnum::PENDING;
            });


        }

        return $this->render('driver/pending_orders.html.twig', [
            'pendingOrders' => $orders,
            'driver' => $driver,
        ]);
    }



    /**
     * @Route("/status/set", name="assign_driver_status", methods={"GET"})
     */
    public function assignDriverStatus(Request $request): Response
    {

        $isWorking = $request->query->get('isWorking');

        /** @var User $user */
        $user = $this->getUser();

        if (is_null($user->getDriver())) {
            $this->$this->addFlash("danger", "User is not a driver");
            return $this->redirectToRoute('driver_pending_orders');
        }

        $user->getDriver()->setIsWorking($isWorking == 'true' ? 1 : 0);

        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('driver_pending_orders');
    }

    /**
     * @Route("/assign/order/{id}", name="driver_assign_order", methods={"GET"})
     */
    public function assignOrderToDriver(Order $order, NotificationService $notificationService, Publisher $publisher): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        /** @var Driver $driver */
        $driver = $user->getDriver();

        $order->setDriver($driver);
        $order->setStatus(OrderStatusEnum::IN_PROGRESS);
        $this->getDoctrine()->getManager()->flush();

        $orderId = $order->getId();
        $notificationService->notify("order/$orderId", ["status" => 'A driver has accepted Your request!'], $publisher);

        return $this->redirectToRoute('order_show', [
            'id' => $order->getId(),
        ]);
    }

    /**
     * @Route("/", name="driver_index", methods={"GET"})
     */
    public function index(DriverRepository $driverRepository): Response
    {
        return $this->render('driver/index.html.twig', [
            'drivers' => $driverRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="driver_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $driver = new Driver();
        $form = $this->createForm(DriverType::class, $driver);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $driver->getUser()->setDriver($driver);
            $driver->getUser()->setRoles(['ROLE_DRIVER']);
            $entityManager->persist($driver);
            $entityManager->flush();

            return $this->redirectToRoute('driver_index');
        }

        return $this->render('driver/new.html.twig', [
            'driver' => $driver,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="driver_show", methods={"GET"})
     */
    public function show(Driver $driver): Response
    {
        return $this->render('driver/show.html.twig', [
            'driver' => $driver,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="driver_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Driver $driver): Response
    {
        $form = $this->createForm(DriverType::class, $driver);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('driver_index');
        }

        return $this->render('driver/edit.html.twig', [
            'driver' => $driver,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="driver_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Driver $driver): Response
    {
        if ($this->isCsrfTokenValid('delete' . $driver->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($driver);
            $entityManager->flush();
        }

        return $this->redirectToRoute('driver_index');
    }


}
