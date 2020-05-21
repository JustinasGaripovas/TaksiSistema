<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CarTypeRepository")
 */
class CarType
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
     * @ORM\Column(type="integer")
     */
    private $price_per_km;

    /**
     * @ORM\Column(type="integer")
     */
    private $price_per_minute;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Car", mappedBy="type", cascade={"remove"})
     */
    private $cars;

    public function __construct()
    {
        $this->cars = new ArrayCollection();
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

    public function getPricePerKm(): ?int
    {
        return $this->price_per_km;
    }

    public function setPricePerKm(int $price_per_km): self
    {
        $this->price_per_km = $price_per_km;

        return $this;
    }

    public function getPricePerMinute(): ?int
    {
        return $this->price_per_minute;
    }

    public function setPricePerMinute(int $price_per_minute): self
    {
        $this->price_per_minute = $price_per_minute;

        return $this;
    }

    /**
     * @return Collection|Car[]
     */
    public function getCars(): Collection
    {
        return $this->cars;
    }

    public function addCar(Car $car): self
    {
        if (!$this->cars->contains($car)) {
            $this->cars[] = $car;
            $car->setType($this);
        }

        return $this;
    }

    public function removeCar(Car $car): self
    {
        if ($this->cars->contains($car)) {
            $this->cars->removeElement($car);
            // set the owning side to null (unless already changed)
            if ($car->getType() === $this) {
                $car->setType(null);
            }
        }

        return $this;
    }
}
