<?php

namespace App\Form;

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
                'row_attr' => [
                    'class' => 'divContact'
                ]
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
                'row_attr' => [
                    'class' => 'divContact'
                ]
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
                'row_attr' => [
                    'class' => 'divContact'
                ]
            ])
            ->add("objet", ChoiceType::class, [
                "choices" => [
                    "Information" => "info",
                    "Inscription" => "inscription",
                    "Devenir Sponsor" => "sponsor",
                    "Autre" => "autre"
                ],
                "label_attr" => [
                    "class" => "form-control",
                    "id" => "labelContactObjet"
                ],
                "attr" => [
                    "class" => "form-control inputContact"
                ],
                'row_attr' => [
                    'class' => 'divContact'
                ]
            ])
            ->add("message", TextareaType::class, [
                "label" => "Votre message",
                "label_attr" => [
                    "class" => "form-control",
                    "id" => "labelContactMessage"
                ],
                "attr" => [
                    "placeholder" => "Votre message",
                    "class" => "form-control inputContact"
                ],
                'row_attr' => [
                    'class' => 'divContact'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
