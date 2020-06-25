<?php

namespace App\Form;

use App\Entity\Convocation;
use App\Entity\Equipe;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConvocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('equipes', EntityType::class, [
                "class" => Equipe::class,
                "choice_label" => "name",
                "label" => "Choisir une équipe",
                "label_attr" => [
                    "class" => "form-control label",
                ],
                "attr" => [
                    "class" => "form-control input"
                ]
            ])
            ->add('day', ChoiceType::class, [
                "label" => "Jour",
                "choices" => [
                    "Lundi" => "Lundi",
                    "Mardi" => "Mardi",
                    "Mercredi" => "Mercredi",
                    "Jeudi" => "Jeudi",
                    "Vendredi" => "Vendredi",
                    "Samedi" => "Samedi",
                    "Dimanche" => "Dimanche"
                ],
                "label_attr" => [
                    "class" => "form-control label",
                ],
                "attr" => [
                    "placeholder" => "Jour d'entraînement",
                    "class" => "form-control input"
                ]
            ])
            ->add('horaire', TimeType::class, [
                "label" => "Horaire",
                "label_attr" => [
                    "class" => "form-control label",
                ],
                "attr" => [
                    "class" => "form-control input"
                ]
            ])
            ->add('address', TextType::class, [
                "label" => "Adresse",
                "label_attr" => [
                    "class" => "form-control label",
                ],
                "attr" => [
                    "placeholder" => "Adresse du gymnase",
                    "class" => "form-control input"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Convocation::class,
        ]);
    }
}
