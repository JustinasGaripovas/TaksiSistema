<?php


namespace App\Service;


use App\Entity\Order;
use Symfony\Component\HttpFoundation\JsonResponse;

class CommunicationService
{
    public function CallToNumber(Order $order)
    {
        //TODO: Some validation, or some must do actions

        return new JsonResponse(
            [
//                'driver_name' => $order->getDriver()->getUser()
            ]
        );

    }

    public function WriteLetterToEmail(string $email)
    {

    }
}