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
     * @ORM\ManyToMany(targetEntity=MemberClub::class, mappedBy="fonctionClub")
     */
    private $memberClubs;

    public function __construct()
    {
        $this->memberClubs = new ArrayCollection();
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
     * @return Collection|MemberClub[]
     */
    public function getMemberClubs(): Collection
    {
        return $this->memberClubs;
    }

    public function addMemberClub(MemberClub $memberClub): self
    {
        if (!$this->memberClubs->contains($memberClub)) {
            $this->memberClubs[] = $memberClub;
            $memberClub->addFonctionClub($this);
        }

        return $this;
    }

    public function removeMemberClub(MemberClub $memberClub): self
    {
        if ($this->memberClubs->contains($memberClub)) {
            $this->memberClubs->removeElement($memberClub);
            $memberClub->removeFonctionClub($this);
        }

        return $this;
    }
}
