<?php

namespace App\Entity;

use App\Repository\MemberClubRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=MemberClubRepository::class)
 * @Vich\Uploadable()
 */
class MemberClub
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
    private $surname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Regex(
     *      pattern="/([0-9]{2}-){4}[0-9]{2}/",
     *      match=true,
     *      message="Votre numéro de téléphone doit être de type '06-45-00-98-54'"
     * )
     */
    private $telephone;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity=FonctionClub::class, inversedBy="memberClubs")
     */
    private $fonctionClub;

    /**
     * @ORM\ManyToMany(targetEntity=Equipe::class, mappedBy="memberClubs")
     */
    private $equipes;

    /**
     * @Assert\File(
     *     maxSize = "16M",
     *     maxSizeMessage = "Fichier trop lourd, veuillez réduire son poids avec un convertisseur par exemple.",
     *     mimeTypes = {"image/jpg", "image/png", "image/jpeg"},
     *     mimeTypesMessage = "Mauvais format d'image, veuillez mettre une image de format JPG, PNG ou JPEG."
     * )
     * @Vich\UploadableField(mapping="memberClub_upload", fileNameProperty="imageName")
     * @var File|null
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imageName;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $title;

    public function __construct()
    {
        $this->fonctionClub = new ArrayCollection();
        $this->equipes = new ArrayCollection();
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

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getPrenomNom()
    {
        return $this->name . " " . strtoupper($this->surname);
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|FonctionClub[]
     */
    public function getFonctionClub(): Collection
    {
        return $this->fonctionClub;
    }

    public function addFonctionClub(FonctionClub $fonctionClub): self
    {
        if (!$this->fonctionClub->contains($fonctionClub)) {
            $this->fonctionClub[] = $fonctionClub;
        }

        return $this;
    }

    public function removeFonctionClub(FonctionClub $fonctionClub): self
    {
        if ($this->fonctionClub->contains($fonctionClub)) {
            $this->fonctionClub->removeElement($fonctionClub);
        }

        return $this;
    }

    /**
     * @return Collection|Equipe[]
     */
    public function getEquipes(): Collection
    {
        return $this->equipes;
    }

    public function addEquipe(Equipe $equipe): self
    {
        if (!$this->equipes->contains($equipe)) {
            $this->equipes[] = $equipe;
        }

        return $this;
    }

    public function removeEquipe(Equipe $equipe): self
    {
        if ($this->equipes->contains($equipe)) {
            $this->equipes->removeElement($equipe);
        }

        return $this;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName( ?string $imageName): self
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * @param File|null $imageFile
     * @return MemberClub
     */
    public function setImageFile(?File $imageFile): MemberClub
    {
        $this->imageFile = $imageFile;
        if ($this->imageFile instanceof UploadedFile)
        {
            $this->updatedAt = new \DateTime("now", new \DateTimeZone("Europe/Paris"));
        }
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }
}
