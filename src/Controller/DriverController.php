<?php

namespace App\Controller;

use App\Entity\Driver;
use App\Entity\Order;
use App\Enum\OrderStatusEnum;
use App\Form\DriverType;
use App\Repository\DriverRepository;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/driver")
 */
class DriverController extends AbstractController
{
    /**
     * @Route("/pending", name="driver_pending_orders", methods={"GET"})
     */
    public function pendingOrderIndex(OrderRepository $orderRepository): Response
    {
        /** @var Driver $driver */
        $driver = $this->getDoctrine()->getRepository(Driver::class)->find(1);

        $orders = [];

        if ($driver->getIsWorking()) {
            $orders = $orderRepository->findAllByStatus(OrderStatusEnum::PENDING);
        }

        return $this->render('driver/pending_orders.html.twig', [
            'pendingOrders' => $orders,
            'driver' => $driver,
        ]);
    }

    /**
     * @Route("/status/set", name="assign_status", methods={"GET"})
     */
    public function assignDriverStatus(Request $request, OrderRepository $orderRepository): Response
    {

        $isWorking = $request->query->get('isWorking');

        dump($isWorking);

        $driver = $this->getDoctrine()->getRepository(Driver::class)->find(1);
        $entityManager = $this->getDoctrine()->getManager();

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($driver);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        $driver->setIsWorking($isWorking == 'true' ? 1 : 0);

        return $this->render('driver/pending_orders.html.twig', [
            'driver' => $driver,
            'pendingOrders' => $orderRepository->findAllByStatus(OrderStatusEnum::PENDING),
        ]);
    }

    /**
     * @Route("/assign/order/{id}", name="driver_assign_order", methods={"GET"})
     */
    public function assignOrderToDriver(DriverRepository $driverRepository, Order $order): Response
    {
        //TODO: Get current user with is logged in instead of placing in mocked id
        /** @var Driver $driver */
        $driver = $driverRepository->findBy(['id' => 1]);

        //TODO: Validation to check if there is both order and driver

        $order->setStatus(OrderStatusEnum::IN_PROGRESS);
        $this->getDoctrine()->getManager()->flush();

        return $this->render('order/show.html.twig', [
            'order' => $order,
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
        if ($this->isCsrfTokenValid('delete'.$driver->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($driver);
            $entityManager->flush();
        }

        return $this->redirectToRoute('driver_index');
    }


}
