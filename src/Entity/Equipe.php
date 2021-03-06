<?php

namespace App\Entity;

use App\Repository\EquipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=EquipeRepository::class)
 * @UniqueEntity(
 *  fields={"name"},
 *  message="Ce nom d'équipe existe déjà !"
 * )
 */
class Equipe
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Gedmo\Slug(fields={"name"})
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity=Convocation::class, mappedBy="equipes", orphanRemoval=true)
     */
    private $convocations;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $widgetId;

    /**
     * @ORM\OneToMany(targetEntity=PhotoEquipe::class, mappedBy="equipe", cascade={"persist", "remove"})
     */
    private $photoEquipes;

    /**
     * @ORM\ManyToMany(targetEntity=MemberClub::class, inversedBy="equipes")
     */
    private $memberClubs;

    public function __construct()
    {
        $this->convocations = new ArrayCollection();
        $this->photoEquipes = new ArrayCollection();
        $this->memberClubs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return strtoupper($this->name);
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getSlug(): ?string
    {
        return strtoupper($this->slug);
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection|Convocation[]
     */
    public function getConvocations(): Collection
    {
        return $this->convocations;
    }

    public function addConvocation(Convocation $convocation): self
    {
        if (!$this->convocations->contains($convocation)) {
            $this->convocations[] = $convocation;
            $convocation->setEquipes($this);
        }

        return $this;
    }

    public function removeConvocation(Convocation $convocation): self
    {
        if ($this->convocations->contains($convocation)) {
            $this->convocations->removeElement($convocation);
            // set the owning side to null (unless already changed)
            if ($convocation->getEquipes() === $this) {
                $convocation->setEquipes(null);
            }
        }

        return $this;
    }

    public function getWidgetId(): ?string
    {
        return $this->widgetId;
    }

    public function setWidgetId(?string $widgetId): self
    {
        $this->widgetId = $widgetId;

        return $this;
    }

    /**
     * @return Collection|PhotoEquipe[]
     */
    public function getPhotoEquipes(): Collection
    {
        return $this->photoEquipes;
    }

    public function addPhotoEquipe(PhotoEquipe $photoEquipe): self
    {
        if (!$this->photoEquipes->contains($photoEquipe)) {
            $this->photoEquipes[] = $photoEquipe;
            $photoEquipe->setEquipe($this);
        }

        return $this;
    }

    public function removePhotoEquipe(PhotoEquipe $photoEquipe): self
    {
        if ($this->photoEquipes->contains($photoEquipe)) {
            $this->photoEquipes->removeElement($photoEquipe);
            // set the owning side to null (unless already changed)
            if ($photoEquipe->getEquipe() === $this) {
                $photoEquipe->setEquipe(null);
            }
        }

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
            $memberClub->addEquipe($this);
        }

        return $this;
    }

    public function removeMemberClub(MemberClub $memberClub): self
    {
        if ($this->memberClubs->contains($memberClub)) {
            $this->memberClubs->removeElement($memberClub);
            $memberClub->removeEquipe($this);
        }

        return $this;
    }
}
