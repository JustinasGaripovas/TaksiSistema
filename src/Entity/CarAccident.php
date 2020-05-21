<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CarAccidentRepository")
 */
class CarAccident
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $accidentDate;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $arePeopleHurt;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $estimatedDamageCost;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isInsured;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Order", mappedBy="carAccident", cascade={"persist", "remove"})
     */
    private $relatedOrder;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAccidentDate(): ?\DateTimeInterface
    {
        return $this->accidentDate;
    }

    public function setAccidentDate(\DateTimeInterface $accidentDate): self
    {
        $this->accidentDate = $accidentDate;

        return $this;
    }

    public function getArePeopleHurt(): ?bool
    {
        return $this->arePeopleHurt;
    }

    public function setArePeopleHurt(?bool $arePeopleHurt): self
    {
        $this->arePeopleHurt = $arePeopleHurt;

        return $this;
    }

    public function getEstimatedDamageCost(): ?float
    {
        return $this->estimatedDamageCost;
    }

    public function setEstimatedDamageCost(?float $estimatedDamageCost): self
    {
        $this->estimatedDamageCost = $estimatedDamageCost;

        return $this;
    }

    public function getIsInsured(): ?bool
    {
        return $this->isInsured;
    }

    public function setIsInsured(?bool $isInsured): self
    {
        $this->isInsured = $isInsured;

        return $this;
    }

    public function getRelatedOrder(): ?Order
    {
        return $this->relatedOrder;
    }

    public function setRelatedOrder(?Order $relatedOrder): self
    {
        $this->relatedOrder = $relatedOrder;

        // set (or unset) the owning side of the relation if necessary
        $newCarAccident = null === $relatedOrder ? null : $this;
        if ($relatedOrder->getCarAccident() !== $newCarAccident) {
            $relatedOrder->setCarAccident($newCarAccident);
        }

        return $this;
    }
}
