<?php
namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Contact
{
    const OBJET = [
        0 => "Information",
        1 => "Inscription",
        2 => "Devenir Sponsor",
        3 => "Autre"
    ];

    /**
     * @var string|null
     * @Assert\NotBlank(message="test")
     * @Assert\Length(min=2, max=100, minMessage = "Votre nom doit contenir au moins 2 caractères")
     * @Assert\Regex(pattern="/\d/", match=false, message="Votre nom ne doit pas contenir des chiffres")
     */
    private $surname;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(min=2, max=100, minMessage = "Votre prénom doit contenir au moins 2 caractères")
     * @Assert\Regex(pattern="/\d/", match=false, message="Votre nom ne doit pas contenir des chiffres")
     */
    private $name;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Email(message="Veuillez entrer une adresse email valide")
     */
    private $email;

    /**
     * @var integer|null
     */
    private $objet;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(min=10, minMessage="Votre message doit contenir au moins 10 caractères")
     */
    private $message;

    /**
     * @return string|null
     */
    public function getSurname(): ?string
    {
        return $this->surname;
    }

    /**
     * @param string|null $surname
     * @return Contact
     */
    public function setSurname(?string $surname): Contact
    {
        $this->surname = $surname;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return Contact
     */
    public function setName(?string $name): Contact
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     * @return Contact
     */
    public function setEmail(?string $email): Contact
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getObjet(): ?int
    {
        return $this->objet;
    }

    /**
     * @param int|null $objet
     * @return Contact
     */
    public function setObjet(?int $objet): Contact
    {
        $this->objet = $objet;
        return $this;
    }

    /**
     * @return string
     */
    public function getObjetType(): string
    {
        return self::OBJET[$this->objet];
    }

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param string|null $message
     * @return Contact
     */
    public function setMessage(?string $message): Contact
    {
        $this->message = $message;
        return $this;
    }



}