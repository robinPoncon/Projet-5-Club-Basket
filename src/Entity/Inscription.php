<?php
namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Inscription
{

    /**
    * @var string|null
    * @Assert\NotBlank(message="test")
    * @Assert\Length(min=2, max=100, minMessage = "Votre nom doit contenir au moins 2 caractères")
    * @Assert\Regex(pattern="/\d/", match=false, message="Votre nom ne doit pas contenir de chiffres")
    */
    private $surname;

    /**
    * @var string|null
    * @Assert\NotBlank()
    * @Assert\Length(min=2, max=100, minMessage = "Votre prénom doit contenir au moins 2 caractères")
    * @Assert\Regex(pattern="/\d/", match=false, message="Votre nom ne doit pas contenir de chiffres")
    */
    private $name;

    /**
     * @var integer|null
     */
    private $age;

    /**
    * @var string|null
    * @Assert\NotBlank()
    * @Assert\Email(message="Veuillez entrer une adresse email valide")
    */
    private $email;


    /**
    * @return string|null
    */
    public function getSurname(): ?string
    {
        return $this->surname;
    }

    /**
    * @param string|null $surname
    * @return Inscription
    */
    public function setSurname(?string $surname): Inscription
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
    * @return Inscription
    */
    public function setName(?string $name): Inscription
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getAge(): ?int
    {
        return $this->age;
    }

    /**
     * @param int|null $age
     * @return Inscription
     */
    public function setAge(?int $age): Inscription
    {
        $this->age = $age;
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
    * @return Inscription
    */
    public function setEmail(?string $email): Inscription
    {
        $this->email = $email;
        return $this;
    }


}