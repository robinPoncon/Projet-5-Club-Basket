<?php
namespace App\Form;

use App\Entity\Diaporama;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DiaporamaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('photoDiapos', CollectionType::class, [
                'entry_type' => PhotoDiaporamaType::class,
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
            'data_class' => Diaporama::class,
        ]);
    }
}