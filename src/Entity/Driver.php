<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DriverRepository")
 */
class Driver
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
    private $driverId;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $averageRating;

    /**
     * @ORM\Column(type="integer")
     */
    private $completeOrderCount;

    /**
     * @ORM\Column(type="integer")
     */
    private $unfinishedOrderCount;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Order", mappedBy="driver")
     */
    private $orders;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getUser()->__toString();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDriverId(): ?string
    {
        return $this->driverId;
    }

    public function setDriverId(string $driverId): self
    {
        $this->driverId = $driverId;

        return $this;
    }

    public function getAverageRating(): ?float
    {
        return $this->averageRating;
    }

    public function setAverageRating(?float $averageRating): self
    {
        $this->averageRating = $averageRating;

        return $this;
    }

    public function getCompleteOrderCount(): ?int
    {
        return $this->completeOrderCount;
    }

    public function setCompleteOrderCount(int $completeOrderCount): self
    {
        $this->completeOrderCount = $completeOrderCount;

        return $this;
    }

    public function getUnfinishedOrderCount(): ?int
    {
        return $this->unfinishedOrderCount;
    }

    public function setUnfinishedOrderCount(int $unfinishedOrderCount): self
    {
        $this->unfinishedOrderCount = $unfinishedOrderCount;

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
            $order->setDriver($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->contains($order)) {
            $this->orders->removeElement($order);
            // set the owning side to null (unless already changed)
            if ($order->getDriver() === $this) {
                $order->setDriver(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
