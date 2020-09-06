<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=ProduitRepository::class)
 * @UniqueEntity(
 *  fields={"name"},
 *  message="Ce nom de produit existe déjà !"
 * )
 */
class Produit
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
     * @ORM\Column(type="string", length=255)
     */
    private $taille;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $color;

    /**
     * @ORM\Column(type="smallint")
     */
    private $quantity;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Gedmo\Slug(fields={"name"})
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity=PhotoProduit::class, mappedBy="produit", orphanRemoval=true)
     */
    private $photoProduits;

    public function __construct()
    {
        $this->photoProduits = new ArrayCollection();
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

    public function getTaille(): ?string
    {
        return $this->taille;
    }

    public function setTaille(string $taille): self
    {
        $this->taille = $taille;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return Collection|PhotoProduit[]
     */
    public function getPhotoProduits(): Collection
    {
        return $this->photoProduits;
    }

    public function addPhotoProduit(PhotoProduit $photoProduit): self
    {
        if (!$this->photoProduits->contains($photoProduit)) {
            $this->photoProduits[] = $photoProduit;
            $photoProduit->setProduit($this);
        }

        return $this;
    }

    public function removePhotoProduit(PhotoProduit $photoProduit): self
    {
        if ($this->photoProduits->contains($photoProduit)) {
            $this->photoProduits->removeElement($photoProduit);
            // set the owning side to null (unless already changed)
            if ($photoProduit->getProduit() === $this) {
                $photoProduit->setProduit(null);
            }
        }

        return $this;
    }
}
