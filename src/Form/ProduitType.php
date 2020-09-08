<?php

namespace App\Form;

use App\Entity\Caracteristique;
use App\Entity\Produit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                "label" => "Nom du produit",
                "label_attr" => [
                    "class" => "form-control label",
                ],
                "attr" => [
                    "placeholder" => "t-shirt, ballon, maillot, etc",
                    "class" => "form-control input"
                ]
            ])
            ->add('price', MoneyType::class, [
                "label" => "Prix",
                "currency" => "",
                "label_attr" => [
                    "class" => "form-control label",
                ],
                "attr" => [
                    "placeholder" => "80, 44, 15, etc",
                    "class" => "form-control input"
                ]
            ])
            ->add('photoProduits', CollectionType::class, [
                'entry_type' => PhotoProduitType::class,
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
            'data_class' => Produit::class,
        ]);
    }
}
