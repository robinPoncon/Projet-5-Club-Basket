<?php

namespace App\Form;

use App\Entity\Color;
use App\Entity\Produit;
use App\Entity\Taille;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TailleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("produit", EntityType::class, [
                "class" => Produit::class,
                "choice_label" => "name",
                "label_attr" => [
                    "class" => "form-control label",
                ],
                "attr" => [
                    "class" => "form-control input"
                ]
            ])
            ->add("color", EntityType::class, [
                "class" => Color::class,
                "choice_label" => "name",
                "label" => "couleur",
                "label_attr" => [
                    "class" => "form-control label",
                ],
                "attr" => [
                    "class" => "form-control input"
                ]
            ])
            ->add('name', TextType::class, [
                "label" => "Taille",
                "label_attr" => [
                    "class" => "form-control label",
                ],
                "attr" => [
                    "placeholder" => "M, XL, 12ans, 42, etc",
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Taille::class,
        ]);
    }
}
