<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VehicleTypeRepository")
 */
class VehicleType
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     */
    private $rate_km;

    /**
     * @ORM\Column(type="float")
     */
    private $rate_min;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Rate", mappedBy="vehicle_type", orphanRemoval=true)
     */
    private $rates;

    public function __construct()
    {
        $this->rates = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getRateKm(): ?float
    {
        return $this->rate_km;
    }

    public function setRateKm(float $rate_km): self
    {
        $this->rate_km = $rate_km;

        return $this;
    }

    public function getRateMin(): ?float
    {
        return $this->rate_min;
    }

    public function setRateMin(float $rate_min): self
    {
        $this->rate_min = $rate_min;

        return $this;
    }

    /**
     * @return Collection|Rate[]
     */
    public function getRates(): Collection
    {
        return $this->rates;
    }

    public function addRate(Rate $rate): self
    {
        if (!$this->rates->contains($rate)) {
            $this->rates[] = $rate;
            $rate->setVehicleType($this);
        }

        return $this;
    }

    public function removeRate(Rate $rate): self
    {
        if ($this->rates->contains($rate)) {
            $this->rates->removeElement($rate);
            // set the owning side to null (unless already changed)
            if ($rate->getVehicleType() === $this) {
                $rate->setVehicleType(null);
            }
        }

        return $this;
    }
}
