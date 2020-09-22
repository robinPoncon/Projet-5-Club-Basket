<?php

namespace App\Entity;

use App\Repository\TailleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TailleRepository::class)
 */
class Taille
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
     * @ORM\Column(type="smallint")
     */
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity=Color::class, inversedBy="tailles")
     */
    private $color;

    /**
     * @ORM\OneToOne(targetEntity=Order::class, mappedBy="tailleProduit")
     */
    private $orderUser;

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

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getColor(): ?Color
    {
        return $this->color;
    }

    public function setColor(?Color $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getOrderUser(): ?Order
    {
        return $this->orderUser;
    }

    public function setOrderUser(?Order $orderUser): self
    {
        $this->orderUser = $orderUser;

        // set (or unset) the owning side of the relation if necessary
        $newTailleProduit = null === $orderUser ? null : $this;
        if ($orderUser->getTailleProduit() !== $newTailleProduit) {
            $orderUser->setTailleProduit($newTailleProduit);
        }

        return $this;
    }
}
