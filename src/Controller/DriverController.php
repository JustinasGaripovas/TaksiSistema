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
        return $this->render('driver/pending_orders.html.twig', [
            'pendingOrders' => $orderRepository->findAllByStatus(OrderStatusEnum::PENDING),
        ]);
    }

    /**
     * @Route("/assign/order/{idOrder}", name="driver_assign_order", methods={"GET"})
     */
    public function assignOrderToDriver(DriverRepository $driverRepository,OrderRepository $orderRepository, int $idDriver, int $idOrder): Response
    {
        //TODO: Get current user with is logged in instead of placing in mocked id
        /** @var Driver $driver */
        $driver = $driverRepository->findBy(['id' => 1]);
        /** @var Order $order */
        $order = $orderRepository->findBy(['id' => $idOrder]);

        //TODO: Validation to check if there is both order and driver

        $order->setStatus(OrderStatusEnum::IN_PROGRESS);
        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse(
            [
                'status' => 'OK'
            ]
        );
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
