<?php

namespace App\Entity;

use App\Repository\PhotoArticleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PhotoArticleRepository::class)
 * @Vich\Uploadable()
 */
class PhotoArticle
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
     * @Vich\UploadableField(mapping="article_upload", fileNameProperty="imageName")
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
     * @ORM\Column(type="boolean", options={"default":false})
     */
    private $important;

    /**
     * @ORM\ManyToOne(targetEntity=Article::class, inversedBy="photoArticles")
     */
    private $article;

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
     * @return PhotoArticle
     */
    public function setImageFile(?File $imageFile): PhotoArticle
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

    public function getImportant(): ?bool
    {
        return $this->important;
    }

    public function setImportant(?bool $important): self
    {
        $this->important = $important;

        return $this;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): self
    {
        $this->article = $article;

        return $this;
    }
}
