<?php

namespace App\Form;

use App\Entity\Equipe;
use App\Entity\MemberClub;
use App\Repository\FonctionClubRepository;
use App\Repository\MemberClubRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EquipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                "label" => "Nom de l'équipe",
                "label_attr" => [
                    "class" => "form-control label",
                ],
                "attr" => [
                    "placeholder" => "Nom de l'équipe",
                    "class" => "form-control input"
                ]
            ])
            ->add('type', ChoiceType::class, [
                "choices" => [
                    "garçons" => "garçons",
                    "filles" => "filles",
                    "loisir" => "loisir"
                ],
                "label" => "Catégorie d'équipe",
                "label_attr" => [
                    "class" => "form-control label",
                ],
                "attr" => [
                    "class" => "form-control input"
                ]
            ])
            ->add('widgetId', TextType::class, [
                "label" => "Widget scorenco",
                "label_attr" => [
                    "class" => "form-control label",
                ],
                "attr" => [
                    "placeholder" => "Code widget",
                    "class" => "form-control input",
                ],
                "required" => false
            ])
            ->add("memberClubs", EntityType::class, [
                "class" => MemberClub::class,
                'choice_label' => "PrenomNom",
                "required" => false,
                'query_builder' => function(MemberClubRepository $memberClubRepo)
                {
                    return $memberClubRepo->findByFonctionClub(6);
                },
                "multiple" => true,
                "expanded" => true,
                "label" => "Entraîneur",
                "label_attr" => [
                    "class" => "form-control label"
                ],
                "attr" => [
                    "class" => "form-control input"
                ],
            ])
            ->add('photoEquipes', CollectionType::class, [
                'entry_type' => PhotoEquipesType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                "label" => " ",
                "required" => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Equipe::class,
        ]);
    }
}
