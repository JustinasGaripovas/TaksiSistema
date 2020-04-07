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
    private $driverRating;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $passengerRating;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Driver", inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $driver;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $latCoordinate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lngCoordinate;

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

    public function getDriverRating(): ?int
    {
        return $this->driverRating;
    }

    public function setDriverRating(?int $driverRating): self
    {
        $this->driverRating = $driverRating;

        return $this;
    }

    public function getPassengerRating(): ?int
    {
        return $this->passengerRating;
    }

    public function setPassengerRating(?int $passengerRating): self
    {
        $this->passengerRating = $passengerRating;

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

    public function getLatCoordinate(): ?string
    {
        return $this->latCoordinate;
    }

    public function setLatCoordinate(?string $latCoordinate): self
    {
        $this->latCoordinate = $latCoordinate;

        return $this;
    }

    public function getLngCoordinate(): ?string
    {
        return $this->lngCoordinate;
    }

    public function setLngCoordinate(string $lngCoordinate): self
    {
        $this->lngCoordinate = $lngCoordinate;

        return $this;
    }
}
