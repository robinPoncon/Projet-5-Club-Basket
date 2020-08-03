<?php
namespace App\Notification;

use App\Entity\Inscription;
use Swift_Mailer;
use Swift_Message;
use Twig\Environment;

class InscriptionNotification
{
    /**
     * @var Swift_Mailer
     */
    private $mailer;

    /**
     * @var Environment
     */
    private $renderer;

    public function __construct(\Swift_Mailer $mailer, Environment $renderer)
    {
        $this->mailer = $mailer;
        $this->renderer = $renderer;
    }

    public function notify(Inscription $inscription)
    {
        $message = (new \Swift_Message("test"))
            ->setSubject("Inscription BCM")
            ->setFrom("basket@test-club.robin-poncon.com")
            ->setTo([
                "basket@test-club.robin-poncon.com",
                "poncon.robin@gmail.com" => "Nelly",
            ])
            ->setReplyTo($inscription->getEmail())
            ->setBody($this->renderer->render("emails/inscription-email.html.twig", [
                "inscription" => $inscription
            ]), "text/html");

        $this->mailer->send($message);

    }
}