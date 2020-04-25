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
     * @ORM\ManyToOne(targetEntity="App\Entity\Driver", inversedBy="orders", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $driver;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $latCoordinateStart;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lngCoordinateStart;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $latCoordinateDestination;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lngCoordinateDestination;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $status;

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

    public function getLatCoordinateStart(): ?string
    {
        return $this->latCoordinateStart;
    }

    public function setLatCoordinateStart(?string $latCoordinateStart): self
    {
        $this->latCoordinateStart = $latCoordinateStart;

        return $this;
    }

    public function getLngCoordinateStart(): ?string
    {
        return $this->lngCoordinateStart;
    }

    public function setLngCoordinateStart(string $lngCoordinateStart): self
    {
        $this->lngCoordinateStart = $lngCoordinateStart;

        return $this;
    }

    public function getLatCoordinateDestination(): ?string
    {
        return $this->latCoordinateDestination;
    }

    public function setLatCoordinateDestination(?string $latCoordinateDestination): self
    {
        $this->latCoordinateDestination = $latCoordinateDestination;

        return $this;
    }

    public function getLngCoordinateDestination(): ?string
    {
        return $this->lngCoordinateDestination;
    }

    public function setLngCoordinateDestination(?string $lngCoordinateDestination): self
    {
        $this->lngCoordinateDestination = $lngCoordinateDestination;

        return $this;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }
}
