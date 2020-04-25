<?php

namespace App\Controller;

use App\Entity\CarType;
use App\Form\CarTypeType;
use App\Repository\CarTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/car/type")
 */
class CarTypeController extends AbstractController
{
    /**
     * @Route("/", name="car_type_index", methods={"GET"})
     */
    public function index(CarTypeRepository $carTypeRepository): Response
    {
        return $this->render('car_type/index.html.twig', [
            'car_types' => $carTypeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="car_type_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $carType = new CarType();
        $form = $this->createForm(CarTypeType::class, $carType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($carType);
            $entityManager->flush();

            return $this->redirectToRoute('car_type_index');
        }

        return $this->render('car_type/new.html.twig', [
            'car_type' => $carType,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="car_type_show", methods={"GET"})
     */
    public function show(CarType $carType): Response
    {
        return $this->render('car_type/show.html.twig', [
            'car_type' => $carType,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="car_type_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CarType $carType): Response
    {
        $form = $this->createForm(CarTypeType::class, $carType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('car_type_index');
        }

        return $this->render('car_type/edit.html.twig', [
            'car_type' => $carType,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="car_type_delete", methods={"DELETE"})
     */
    public function delete(Request $request, CarType $carType): Response
    {
        if ($this->isCsrfTokenValid('delete'.$carType->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($carType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('car_type_index');
    }
}
