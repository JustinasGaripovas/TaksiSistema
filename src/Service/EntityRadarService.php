<?php


namespace App\Service;


use App\Entity\Driver;
use App\Entity\Order;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class EntityRadarService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(EntityManagerInterface $entityManager, SerializerInterface $serializer)
    {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
    }


    public function getNearbyEntities($location, $entityType, string $latAccessor = 'lat', string $lngAccessor = 'lng', int $maxDistance = 5000)
    {

        $responseArray = [];
        $entityArray = $this->entityManager->getRepository($entityType)->findAll();

        foreach ($entityArray as $entity) {
            $entityAsArray = $this->serializer->normalize($entity, null);
            if ($this->haversineGreatCircleDistance($location[0], $location[1], $entityAsArray[$latAccessor], $entityAsArray[$lngAccessor]) < $maxDistance) {
                $responseArray[] = $entity;
            }
        }

        return $responseArray;


    }

    //TODO: Some validation, or some must do actions

    function haversineGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
    {
        // convert from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) + cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        return $angle * $earthRadius;
    }

}