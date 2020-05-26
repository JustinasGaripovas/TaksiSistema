<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    use UserTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Driver", mappedBy="user", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $driver;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Admin", mappedBy="user", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $admin;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $roles = [];

//    /**
//     * @ORM\OneToMany(targetEntity="App\Entity\Order", mappedBy="user")
//     */
//    private $orders;


    public function __construct()
    {
        $this->roles = ['ROLE_USER'];
        $this->orders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDriver(): ?Driver
    {
        return $this->driver;
    }

    public function setDriver(Driver $driver): self
    {
        $this->driver = $driver;

        // set the owning side of the relation if necessary
        if ($driver->getUser() !== $this) {
            $driver->setUser($this);
        }

        return $this;
    }

    public function getAdmin(): ?Admin
    {
        return $this->admin;
    }

    public function setAdmin(Admin $admin): self
    {
        $this->admin = $admin;

        // set the owning side of the relation if necessary
        if ($admin->getUser() !== $this) {
            $admin->setUser($this);
        }

        return $this;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function getPassword()
    {
        return $this->passwordEncoded;

        // TODO: Implement getPassword() method.
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function getUsername()
    {
        return $this->email;

        // TODO: Implement getUsername() method.
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function setRoles(?array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

//    /**
//     * @return Collection|Order[]
//     */
//    public function getOrders(): Collection
//    {
//        return $this->orders;
//    }
//
//    public function addOrder(Order $order): self
//    {
//        if (!$this->orders->contains($order)) {
//            $this->orders[] = $order;
//            $order->setUser($this);
//        }
//
//        return $this;
//    }
//
//    public function removeOrder(Order $order): self
//    {
//        if ($this->orders->contains($order)) {
//            $this->orders->removeElement($order);
//            // set the owning side to null (unless already changed)
//            if ($order->getUser() === $this) {
//                $order->setUser(null);
//            }
//        }
//
//        return $this;
//    }
}
