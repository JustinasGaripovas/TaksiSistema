<?php


namespace App\Service;


use App\Entity\Order;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Mercure\Publisher;
use Symfony\Component\Mercure\Update;

class NotificationService
{
    public function notify(string $topic, array $data, Publisher $publisher)
    {
        try {
            $update = new Update(
                $topic,
                json_encode($data)
            );

            // The Publisher service is an invokable object
            $publisher($update);
        }catch (\Exception $exception)
        {
            return false;
        }

        return true;
    }

}