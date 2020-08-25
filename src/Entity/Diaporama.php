<?php

namespace App\Entity;

use App\Repository\DiaporamaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DiaporamaRepository::class)
 */
class Diaporama
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=PhotoDiaporama::class, mappedBy="diaporama")
     */
    private $photoDiapos;

    public function __construct()
    {
        $this->photoDiapos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|PhotoDiaporama[]
     */
    public function getPhotoDiapos(): Collection
    {
        return $this->photoDiapos;
    }

    public function addPhotoDiapo(PhotoDiaporama $photoDiapo): self
    {
        if (!$this->photoDiapos->contains($photoDiapo)) {
            $this->photoDiapos[] = $photoDiapo;
            $photoDiapo->setDiaporama($this);
        }

        return $this;
    }

    public function removePhotoDiapo(PhotoDiaporama $photoDiapo): self
    {
        if ($this->photoDiapos->contains($photoDiapo)) {
            $this->photoDiapos->removeElement($photoDiapo);
            // set the owning side to null (unless already changed)
            if ($photoDiapo->getDiaporama() === $this) {
                $photoDiapo->setDiaporama(null);
            }
        }

        return $this;
    }
}
