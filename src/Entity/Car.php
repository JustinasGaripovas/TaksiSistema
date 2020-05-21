<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CarRepository")
 */
class Car
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
    private $licenseNumber;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isDamaged;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $ManufacturedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $technicallyApprovedTill;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $comment;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CarType", inversedBy="cars")
     */
    private $type;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Order", mappedBy="usedCar")
     */
    private $orders;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLicenseNumber(): ?string
    {
        return $this->licenseNumber;
    }

    public function setLicenseNumber(string $licenseNumber): self
    {
        $this->licenseNumber = $licenseNumber;

        return $this;
    }

    public function getIsDamaged(): ?bool
    {
        return $this->isDamaged;
    }

    public function setIsDamaged(?bool $isDamaged): self
    {
        $this->isDamaged = $isDamaged;

        return $this;
    }

    public function getManufacturedAt(): ?\DateTimeInterface
    {
        return $this->ManufacturedAt;
    }

    public function setManufacturedAt(?\DateTimeInterface $ManufacturedAt): self
    {
        $this->ManufacturedAt = $ManufacturedAt;

        return $this;
    }

    public function getTechnicallyApprovedTill(): ?\DateTimeInterface
    {
        return $this->technicallyApprovedTill;
    }

    public function setTechnicallyApprovedTill(?\DateTimeInterface $technicallyApprovedTill): self
    {
        $this->technicallyApprovedTill = $technicallyApprovedTill;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getType(): ?CarType
    {
        return $this->type;
    }

    public function setType(?CarType $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|Order[]
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->addUsedCar($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->contains($order)) {
            $this->orders->removeElement($order);
            $order->removeUsedCar($this);
        }

        return $this;
    }
}
