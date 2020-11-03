<?php

namespace App\Entity;

use App\Repository\SponsorRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PhotoSponsorRepository::class)
 * @Vich\Uploadable()
 */
class PhotoSponsor
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\File(
     *     maxSize = "16M",
     *     maxSizeMessage = "Fichier trop lourd, veuillez réduire son poids avec un convertisseur par exemple.",
     *     mimeTypes = {"image/jpg", "image/png", "image/jpeg"},
     *     mimeTypesMessage = "Mauvais format d'image, veuillez mettre une image de format JPG, PNG ou JPEG."
     * )
     * @Vich\UploadableField(mapping="sponsor_upload", fileNameProperty="imageName")
     * @var File|null
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imageName;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=Sponsor::class, inversedBy="photoSponsor")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sponsor;

    public function getId(): ?int
    {
        return $this->id;
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
     * @return PhotoSponsor
     */
    public function setImageFile(?File $imageFile): PhotoSponsor
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

    public function getSponsor(): ?Sponsor
    {
        return $this->sponsor;
    }

    public function setSponsor(?Sponsor $sponsor): self
    {
        $this->sponsor = $sponsor;

        return $this;
    }
}
