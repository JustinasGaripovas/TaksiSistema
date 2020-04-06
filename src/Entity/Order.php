<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 * @ORM\Table(name="`order`")
 */
class Order
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $basePrice;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $additionalPrice;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $driversRating;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $passengersRating;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Driver", inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $driver;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBasePrice(): ?int
    {
        return $this->basePrice;
    }

    public function setBasePrice(?int $basePrice): self
    {
        $this->basePrice = $basePrice;

        return $this;
    }

    public function getAdditionalPrice(): ?int
    {
        return $this->additionalPrice;
    }

    public function setAdditionalPrice(?int $additionalPrice): self
    {
        $this->additionalPrice = $additionalPrice;

        return $this;
    }

    public function getDriversRating(): ?int
    {
        return $this->driversRating;
    }

    public function setDriversRating(?int $driversRating): self
    {
        $this->driversRating = $driversRating;

        return $this;
    }

    public function getPassengersRating(): ?int
    {
        return $this->passengersRating;
    }

    public function setPassengersRating(?int $passengersRating): self
    {
        $this->passengersRating = $passengersRating;

        return $this;
    }

    public function getDriver(): ?Driver
    {
        return $this->driver;
    }

    public function setDriver(?Driver $driver): self
    {
        $this->driver = $driver;

        return $this;
    }
}
