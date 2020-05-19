<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RateRepository")
 */
class Rate
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $coefficient;

    /**
     * @ORM\Column(type="time")
     */
    private $available_from;

    /**
     * @ORM\Column(type="time")
     */
    private $available_to;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\VehicleType", inversedBy="rates")
     * @ORM\JoinColumn(nullable=false)
     */
    private $vehicle_type;
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCoefficient(): ?float
    {
        return $this->coefficient;
    }

    public function setCoefficient(float $coefficient): self
    {
        $this->coefficient = $coefficient;

        return $this;
    }

    public function getAvailableFrom(): ?\DateTimeInterface
    {
        return $this->available_from;
    }

    public function setAvailableFrom(\DateTimeInterface $available_from): self
    {
        $this->available_from = $available_from;

        return $this;
    }

    public function getAvailableTo(): ?\DateTimeInterface
    {
        return $this->available_to;
    }

    public function setAvailableTo(\DateTimeInterface $available_to): self
    {
        $this->available_to = $available_to;

        return $this;
    }

    public function getVehicleType(): ?VehicleType
    {
        return $this->vehicle_type;
    }

    public function setVehicleType(?VehicleType $vehicle_type): self
    {
        $this->vehicle_type = $vehicle_type;

        return $this;
    }
}
