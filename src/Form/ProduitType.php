<?php

namespace App\Form;

use App\Entity\Produit;
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
                "label_attr" => [
                    "class" => "form-control label",
                ],
                "attr" => [
                    "placeholder" => "80, 44, 15, etc",
                    "class" => "form-control input"
                ]
            ])
            ->add('quantity', IntegerType::class, [
                "label" => "Quantité",
                "label_attr" => [
                    "class" => "form-control label",
                ],
                "attr" => [
                    "placeholder" => "11, 5, 34, etc",
                    "class" => "form-control input"
                ]
            ])
            ->add('taille', TextType::class, [
                "label" => "Tailles",
                "label_attr" => [
                    "class" => "form-control label",
                ],
                "attr" => [
                    "placeholder" => "M, XL, 12ans, 42, etc",
                    "class" => "form-control input"
                ],
                'property_path' => 'taille[0]',
            ])
            ->add('color', TextType::class, [
                "label" => "Couleurs",
                "label_attr" => [
                    "class" => "form-control label",
                ],
                "attr" => [
                    "placeholder" => "blanc, bleu, noir, etc",
                    "class" => "form-control input"
                ],
                'property_path' => 'taille[0]',
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
