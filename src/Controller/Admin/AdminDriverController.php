<?php


namespace App\Controller\Admin;


use App\Entity\Driver;
use App\Repository\DriverRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/driver")
 */
class AdminDriverController extends AbstractController
{
    /**
     * @Route("/", name="admin_driver_index", methods={"GET"})
     * @param DriverRepository $driverRepository
     * @return Response
     */
    public function index(DriverRepository $driverRepository): Response
    {
        return $this->render('admin/driver/index.html.twig', [
            'drivers' => $driverRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}/statistic", name="admin_driver_statistic", methods={"GET","POST"})
     * @param Driver $driver
     * @return Response
     */
    public function statistic(Driver $driver): Response
    {
        return $this->render('admin/driver/statistic.html.twig', [
            'driver' => $driver,
        ]);
    }

    /**
     * @Route("/{id}/delete", name="admin_driver_delete", methods={"DELETE"})
     * @param Request $request
     * @param Driver $driver
     * @return Response
     */
    public function delete(Request $request, Driver $driver): Response
    {
        if ($this->isCsrfTokenValid('delete'.$driver->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($driver);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_driver_index');
    }
}