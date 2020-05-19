<?php


namespace App\Controller\Admin;


use App\Entity\Discount;
use App\Entity\VehicleType;
use App\Form\DiscountType;
use App\Form\VehicleTypeType;
use App\Repository\DiscountRepository;
use App\Repository\VehicleTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/vehicle_type")
 */
class AdminVehicleTypeController extends AbstractController
{
    /**
     * @Route("/", name="admin_vehicle_type_index", methods={"GET"})
     * @param VehicleTypeRepository $vehicleTypeRepository
     * @return Response
     */
    public function index(VehicleTypeRepository $vehicleTypeRepository): Response
    {
        return $this->render('admin/vehicle_type/index.html.twig', [
            'vehicle_types' => $vehicleTypeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_vehicle_type_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $vehicle_type = new VehicleType();
        $form = $this->createForm(VehicleTypeType::class, $vehicle_type);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($vehicle_type);
            $entityManager->flush();

            return $this->redirectToRoute('admin_vehicle_type_index');
        }

        return $this->render('admin/vehicle_type/new.html.twig', [
            'discount' => $vehicle_type,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name="admin_vehicle_type_delete", methods={"DELETE"})
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
     * @Route("/{id}/edit", name="admin_vehicle_type_edit", methods={"GET","POST"})
     * @param Request $request
     * @param VehicleType $vehicleType
     * @return Response
     */
    public function edit(Request $request, VehicleType $vehicleType): Response
    {
        $form = $this->createForm(VehicleTypeType::class, $vehicleType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_vehicle_type_index');
        }

        return $this->render('admin/vehicle_type/edit.html.twig', [
            'discount' => $vehicleType,
            'form' => $form->createView(),
        ]);
    }
}