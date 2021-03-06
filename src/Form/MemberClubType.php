<?php

namespace App\Form;

use App\Entity\FonctionClub;
use App\Entity\MemberClub;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MemberClubType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                "label" => "Titre au sein du club",
                "label_attr" => [
                    "class" => "form-control label",
                ],
                "attr" => [
                    "placeholder" => "Président, secrétariat, etc",
                    "class" => "form-control input"
                ],
                "required" => false
            ])
            ->add('surname', TextType::class, [
                "label" => "Nom",
                "label_attr" => [
                    "class" => "form-control label",
                ],
                "attr" => [
                    "placeholder" => "Votre nom",
                    "class" => "form-control input"
                ]
            ])
            ->add('name', TextType::class, [
                "label" => "Prénom",
                "label_attr" => [
                    "class" => "form-control label",
                ],
                "attr" => [
                    "placeholder" => "Votre prénom",
                    "class" => "form-control input"
                ]
            ])
            ->add('email', EmailType::class, [
                "label" => "Email",
                "label_attr" => [
                    "class" => "form-control label",
                ],
                "attr" => [
                    "placeholder" => "Votre email",
                    "class" => "form-control input"
                ]
            ])
            ->add("telephone", TelType::class, [
                "label" => "Numéro de téléphone",
                "label_attr" => [
                    "class" => "form-control label",
                ],
                "attr" => [
                    "placeholder" => "06-35-76-54-53",
                    "class" => "form-control input"
                ],
                "required" => false
            ])
            ->add('description', TextareaType::class, [
                "label" => "infos supplémentaires",
                "label_attr" => [
                    "class" => "form-control label",
                ],
                "attr" => [
                    "placeholder" => "président, coach equipe xx, etc",
                    "class" => "form-control input"
                ],
                "required" => false
            ])
            ->add('fonctionClub', EntityType::class, [
                "class" => FonctionClub::class,
                "choice_label" => "name",
                "expanded" => true,
                "multiple" => true,
                "label" => "Fonction dans le club",
                "label_attr" => [
                    "class" => "form-control label",
                ],
                "attr" => [
                    "class" => "form-control input"
                ],
                "required" => true,
            ])
            ->add('imageFile', FileType::class, [
                "label" => "Photo du membre",
                "label_attr" => [
                    "class" => "form-control label",
                ],
                "attr" => [
                    "class" => "form-control input"
                ],
                'row_attr' => [
                    'class' => 'divFormPhoto',
                ],
                "required" => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MemberClub::class,
        ]);
    }
}