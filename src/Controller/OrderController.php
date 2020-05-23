<?php

namespace App\Controller;

use App\Entity\Driver;
use App\Entity\Order;
use App\Entity\User;
use App\Entity\VehicleType;
use App\Enum\OrderStatusEnum;
use App\Form\EvaluateDriverType;
use App\Form\OrderType;
use App\Manager\UserManager;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class OrderController extends AbstractController
{
    /**
     * @Route("/", name="homepage", methods={"GET"})
     */
    public function homepage(OrderRepository $orderRepository, UserManager $userManager): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        /** @var Order $activeOrder */
        $activeOrder = $userManager->getCurrentOrder();

        if(!is_null($activeOrder))
            return $this->redirectToRoute("order_show", ['id' => $activeOrder->getId()]);

        return $this->redirectToRoute("order_new");
    }

    /**
     * @Route("/order/", name="order_index", methods={"GET"})
     */
    public function index(OrderRepository $orderRepository): Response
    {
        return $this->render('order/index.html.twig', [
            'orders' => $orderRepository->findAll(),
        ]);
    }

    /**
     * @Route("/order/new", name="order_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $order = new Order();
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $order->setStatus(OrderStatusEnum::PENDING);
            $order->setBasePrice(1);
            $order->setBasePrice(1);
            $order->setAdditionalPrice(1);
            $order->setDriverRating(1);
            $order->setPassengerRating(1);

            /** @var VehicleType $selectedCarType */
            $selectedCarType = $form['vehicleType']->getData();

            //TODO: Listener which calls itself

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($order);
            $entityManager->flush();

            return $this->redirectToRoute("order_show", ['id' => $order->getId()]);
        }

        return $this->render('order/new.html.twig', [
            'order' => $order,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/order/{id}", name="order_show", methods={"GET"})
     */
    public function show(Order $order): Response
    {
        return $this->render('order/show.html.twig', [
            'order' => $order,
        ]);
    }

    /**
     * @Route("/order/{id}/edit", name="order_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Order $order): Response
    {
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('order_index');
        }

        return $this->render('order/edit.html.twig', [
            'order' => $order,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/order/{id}", name="order_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Order $order): Response
    {
        if ($this->isCsrfTokenValid('delete'.$order->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($order);
            $entityManager->flush();
        }

        return $this->redirectToRoute('order_index');
    }

    /**
     * @Route("/order/cancel/{id}", name="order_cancel", methods={"GET"})
     */
    public function cancel(Order $order)
    {
        $order->setStatus(OrderStatusEnum::CANCELED);
        $order->setBasePrice($this->recalculateOrderPrice($order));

        return new JsonResponse(
            [
                'order_status' => $order->getStatus(),
                'order_price' => $order->getBasePrice()
            ]
        );
    }

    private function recalculateOrderPrice(Order $order)
    {
        return 10;
    }

    /**
     * @Route("/order/{id}/evaluate/driver", name="order_evaluate_driver", methods={"GET"})
     */
    public function evaluateDriver(Request $request, Order $order)
    {
        $form = $this->createForm(EvaluateDriverType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $order->setDriverRating($form['rating']);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute("order_new");
        }

        return $this->render('order/evaluate.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
