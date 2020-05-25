<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('surname', TextType::class, [
                "label" => "Nom",
                "label_attr" => [
                    "class" => "form-control",
                    "id" => "labelContactSurname"
                ],
                "attr" => [
                    "placeholder" => "Votre nom",
                    "class" => "form-control inputContact"
                ],
            ])
            ->add("name", TextType::class, [
                "label" => "Prénom",
                "label_attr" => [
                    "class" => "form-control",
                    "id" => "labelContactName"
                ],
                "attr" => [
                    "placeholder" => "Votre prénom",
                    "class" => "form-control inputContact"
                ],
            ])
            ->add("email", EmailType::class, [
                "label" => "Email",
                "label_attr" => [
                    "class" => "form-control",
                    "id" => "labelContactEmail"
                ],
                "attr" => [
                    "placeholder" => "Votre email",
                    "class" => "form-control inputContact"
                ],
            ])
            ->add("objet", ChoiceType::class, [
                "choices" => $this->getChoices(),
                "label_attr" => [
                    "class" => "form-control",
                    "id" => "labelContactObjet"
                ],
                "attr" => [
                    "class" => "form-control inputContact"
                ],
            ])
            ->add("message", TextareaType::class, [
                "label" => "Message",
                "label_attr" => [
                    "class" => "form-control",
                    "id" => "labelContactMessage"
                ],
                "attr" => [
                    "placeholder" => "Votre message",
                    "class" => "form-control inputContact"
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([

        ]);
    }

    public function getChoices()
    {
        $choices = Contact::OBJET;
        $output = [];
        foreach($choices as $k => $v)
        {
            $output[$v] = $k;
        }
        return $output;
    }
}
