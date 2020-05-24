<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/order")
 */
class AdminOrderController extends AbstractController
{
    /**
     * @Route("/", name="admin_order_index", methods={"GET"})
     * @param OrderRepository $orderRepository
     * @return Response
     */
    public function index(OrderRepository $orderRepository): Response
    {
        return $this->render('admin/order/index.html.twig', [
            'orders' => $orderRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}/view", name="admin_order_view", methods={"GET"})
     * @param Order $order
     * @return Response
     */
    public function view(Order $order): Response
    {
        return $this->render('admin/order/view.html.twig', [
            'order' => $order,
        ]);
    }
}