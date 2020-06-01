<?php

namespace App\Entity;

use App\Repository\FonctionClubRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FonctionClubRepository::class)
 */
class FonctionClub
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
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="fonctionClub")
     */
    private $fonctionClub;

    public function __construct()
    {
        $this->fonctionClub = new ArrayCollection();
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

    /**
     * @return Collection|User[]
     */
    public function getFonctionClub(): Collection
    {
        return $this->fonctionClub;
    }

    public function addFonctionClub(User $fonctionClub): self
    {
        if (!$this->fonctionClub->contains($fonctionClub)) {
            $this->fonctionClub[] = $fonctionClub;
            $fonctionClub->addFonctionClub($this);
        }

        return $this;
    }

    public function removeFonctionClub(User $fonctionClub): self
    {
        if ($this->fonctionClub->contains($fonctionClub)) {
            $this->fonctionClub->removeElement($fonctionClub);
            $fonctionClub->removeFonctionClub($this);
        }

        return $this;
    }
}
