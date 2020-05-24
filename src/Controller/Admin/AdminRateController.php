<?php

namespace App\Controller\Admin;

use App\Entity\Rate;
use App\Form\RateType;
use App\Repository\RateRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/rate")
 */
class AdminRateController extends AbstractController
{
    /**
     * @Route("/", name="admin_rate_index", methods={"GET"})
     * @param RateRepository $rateRepository
     * @return Response
     */
    public function index(RateRepository $rateRepository): Response
    {
        return $this->render('admin/rate/index.html.twig', [
            'rates' => $rateRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_rate_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $rate = new Rate();
        $form = $this->createForm(RateType::class, $rate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rate);
            $entityManager->flush();

            $this->addFlash('success', 'New rate created.');
            return $this->redirectToRoute('admin_rate_index');
        }

        return $this->render('admin/rate/new.html.twig', [
            'rate' => $rate,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name="admin_rate_delete", methods={"DELETE"})
     * @param Request $request
     * @param Rate $rate
     * @return Response
     */
    public function delete(Request $request, Rate $rate): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rate->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($rate);
            $entityManager->flush();
            $this->addFlash('success', 'Rate deleted.');
        }

        return $this->redirectToRoute('admin_rate_index');
    }

    /**
     * @Route("/{id}/edit", name="admin_rate_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Rate $rate
     * @return Response
     */
    public function edit(Request $request, Rate $rate): Response
    {
        $form = $this->createForm(RateType::class, $rate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Rate edited.');
            return $this->redirectToRoute('admin_rate_index');
        }

        return $this->render('admin/rate/edit.html.twig', [
            'rate' => $rate,
            'form' => $form->createView(),
        ]);
    }
}