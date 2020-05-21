<?php


namespace App\Controller\Admin;


use App\Entity\Discount;
use App\Form\DiscountType;
use App\Repository\DiscountRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/discount")
 */
class AdminDiscountController extends AbstractController
{
    /**
     * @Route("/", name="admin_discount_index", methods={"GET"})
     * @param DiscountRepository $discountRepository
     * @return Response
     */
    public function index(DiscountRepository $discountRepository): Response
    {
        return $this->render('admin/discount/index.html.twig', [
            'discounts' => $discountRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_discount_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $discount = new Discount();
        $form = $this->createForm(DiscountType::class, $discount);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($discount);
            $entityManager->flush();

            return $this->redirectToRoute('admin_discount_index');
        }

        return $this->render('admin/discount/new.html.twig', [
            'discount' => $discount,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name="admin_discount_delete", methods={"DELETE"})
     * @param Request $request
     * @param Discount $discount
     * @return Response
     */
    public function delete(Request $request, Discount $discount): Response
    {
        if ($this->isCsrfTokenValid('delete'.$discount->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($discount);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_discount_index');
    }

    /**
     * @Route("/{id}/edit", name="admin_discount_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Discount $discount
     * @return Response
     */
    public function edit(Request $request, Discount $discount): Response
    {
        $form = $this->createForm(DiscountType::class, $discount);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_discount_index');
        }

        return $this->render('admin/discount/edit.html.twig', [
            'discount' => $discount,
            'form' => $form->createView(),
        ]);
    }
}