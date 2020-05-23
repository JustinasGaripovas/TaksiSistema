<?php

namespace App\Controller;

use App\Entity\VehicleType;
use App\Form\VehicleTypeType;
use App\Repository\CarTypeRepository;
use App\Repository\VehicleTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/car/vehicle_type")
 */
class CarTypeController extends AbstractController
{
    /**
     * @Route("/", name="vehicle_type_index", methods={"GET"})
     */
    public function index(VehicleTypeRepository $vehicleTypeRepository): Response
    {
        return $this->render('vehicle_type/index.html.twig', [
            'vehicle_types' => $vehicleTypeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="vehicle_type_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $vehicleType = new VehicleType();
        $form = $this->createForm(VehicleTypeType::class, $vehicleType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($vehicleType);
            $entityManager->flush();

            return $this->redirectToRoute('vehicle_type_index');
        }

        return $this->render('vehicle_type/new.html.twig', [
            'vehicle_type' => $vehicleType,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="vehicle_type_show", methods={"GET"})
     */
    public function show(VehicleType $vehicleType): Response
    {
        return $this->render('vehicle_type/show.html.twig', [
            'vehicle_type' => $vehicleType,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="vehicle_type_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, VehicleType $vehicleType): Response
    {
        $form = $this->createForm(VehicleTypeType::class, $vehicleType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vehicle_type_index');
        }

        return $this->render('vehicle_type/edit.html.twig', [
            'vehicle_type' => $vehicleType,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="vehicle_type_delete", methods={"DELETE"})
     */
    public function delete(Request $request, VehicleType $vehicleType): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vehicleType->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($vehicleType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('vehicle_type_index');
    }
}
