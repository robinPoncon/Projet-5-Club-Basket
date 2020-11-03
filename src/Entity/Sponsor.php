<?php

namespace App\Entity;

use App\Repository\SponsorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SponsorRepository::class)
 */
class Sponsor
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=PhotoSponsor::class, mappedBy="sponsor", cascade={"persist", "remove"})
     */
    private $photoSponsor;

    public function __construct()
    {
        $this->photoSponsor = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|PhotoSponsor[]
     */
    public function getPhotoSponsor(): Collection
    {
        return $this->photoSponsor;
    }

    public function addPhotoSponsor(PhotoSponsor $photoSponsor): self
    {
        if (!$this->photoSponsor->contains($photoSponsor)) {
            $this->photoSponsor[] = $photoSponsor;
            $photoSponsor->setSponsor($this);
        }

        return $this;
    }

    public function removePhotoSponsor(PhotoSponsor $photoSponsor): self
    {
        if ($this->photoSponsor->contains($photoSponsor)) {
            $this->photoSponsor->removeElement($photoSponsor);
            // set the owning side to null (unless already changed)
            if ($photoSponsor->getSponsor() === $this) {
                $photoSponsor->setSponsor(null);
            }
        }

        return $this;
    }
}
