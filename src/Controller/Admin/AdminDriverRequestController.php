<?php

namespace App\Controller\Admin;

use App\Entity\Driver;
use App\Entity\DriverRequest;
use App\Entity\User;
use App\Repository\DriverRequestRepository;
use App\Service\CommunicationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/driver/request")
 */
class AdminDriverRequestController extends AbstractController
{
    /**
     * @Route("/", name="admin_driver_request_index", methods={"GET"})
     * @param DriverRequestRepository $driverRequestRepository
     * @return Response
     */
    public function index(DriverRequestRepository $driverRequestRepository): Response
    {
        return $this->render('admin/driver_request/index.html.twig', [
            'requests' => $driverRequestRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}/accept", name="admin_driver_request_accept")
     * @param Request $request
     * @param DriverRequest $driverRequest
     * @param CommunicationService $communicationService
     * @return Response
     */
    public function accept(Request $request, DriverRequest $driverRequest, CommunicationService $communicationService): Response
    {
        /** @var User $user */
        $user = $request->getUser();
        if (!$user)
        {
            $this->addFlash('error', 'User not found!');
            return $this->redirectToRoute('admin_driver_request_index');
        }

        if ($user->getDriver())
        {
            $this->addFlash('error', 'User already driver!');
            return $this->redirectToRoute('admin_driver_request_index');
        }

        $driver = new Driver();
        $driver->setUser($user);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($driver);
        $entityManager->remove($driverRequest);
        $entityManager->flush();

        $communicationService->WriteLetterToEmail($user->getEmail(), 'Your driver request successfully accepted!');

        $this->addFlash('success', 'User accepted.');
        return $this->redirectToRoute('admin_driver_request_index');
    }

    /**
     * @Route("/{id}/deny", name="admin_driver_request_deny")
     * @param Request $request
     * @param DriverRequest $driverRequest
     * @param CommunicationService $communicationService
     * @return Response
     */
    public function deny(Request $request, DriverRequest $driverRequest, CommunicationService $communicationService): Response
    {
        /** @var User $user */
        $user = $request->getUser();
        if (!$user)
        {
            $this->addFlash('error', 'User not found!');
            return $this->redirectToRoute('admin_driver_request_index');
        }

        if ($user->getDriver())
        {
            $this->addFlash('error', 'User already driver!');
            return $this->redirectToRoute('admin_driver_request_index');
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($driverRequest);
        $entityManager->flush();

        $communicationService->WriteLetterToEmail($user->getEmail(), 'Your driver request was denied!');

        $this->addFlash('success', 'User denied.');
        return $this->redirectToRoute('admin_driver_request_index');
    }
}