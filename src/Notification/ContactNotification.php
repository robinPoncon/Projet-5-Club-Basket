<?php
namespace App\Notification;

use App\Entity\Contact;
use Swift_Mailer;
use Swift_Message;
use Twig\Environment;

class ContactNotification
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

    public function notify(Contact $contact)
    {

        $message = (new \Swift_Message("test"))
            ->setSubject($contact->getObjetType())
            ->setFrom(array($contact->getEmail() => "ContactBCM"))
            ->setTo("basket.meximieux.contact@gmail.com")
            ->setReplyTo($contact->getEmail())
            ->setBody($this->renderer->render("emails/contact-email.html.twig", [
                "contact" => $contact
            ]), "text/html");

        $this->mailer->send($message);

    }
}