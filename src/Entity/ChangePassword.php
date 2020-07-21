<?php

namespace App\Entity;

use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;
use Symfony\Component\Validator\Constraints as Assert;

class ChangePassword
{
    /**
     * @SecurityAssert\UserPassword(message = "Le mot de passe actuel n'est pas le bon, veuillez réessayer")
     */
    protected $oldPassword;

    /**
     * @Assert\Length(min="8", minMessage="Votre mot de passe doit faire minimum 8 caractères")
     */
    protected $newPassword;

    /**
     * @Assert\EqualTo(propertyPath="newPassword", message="Vous n'avez pas taper le même mot de passe")
     */
    public $confirm_newPassword;

    function getOldPassword() {
        return $this->oldPassword;
    }

    function setOldPassword($oldPassword) {
        $this->oldPassword = $oldPassword;
        return $this;
    }

    function getNewPassword() {
        return $this->newPassword;
    }

    function setNewPassword($newPassword) {
        $this->newPassword = $newPassword;
        return $this;
    }
}