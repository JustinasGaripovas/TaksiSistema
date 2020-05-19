<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DiscountRepository")
 */
class Discount
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
    private $code;

    /**
     * @ORM\Column(type="float")
     */
    private $value;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\Column(type="datetime")
     */
    private $available_from;

    /**
     * @ORM\Column(type="datetime")
     */
    private $available_to;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(float $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

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
}
