<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\FilesToPicturesTransformer;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                "label" => "Titre",
                "label_attr" => [
                    "class" => "form-control label",
                ],
                "attr" => [
                    "placeholder" => "Titre de l'article",
                    "class" => "form-control input"
                ]
            ])
            ->add('content', CKEditorType::class, [
                "config" => [
                    "language" => "fr"
                ],
                "label" => "Contenu",
                "label_attr" => [
                    "class" => "form-control label contentPost",
                ],
                "required" => true
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                "choice_label" => "title",
                "multiple" => true,
                "expanded" => true,
                'query_builder' => function(CategoryRepository $categoryRepo)
                {
                    return $categoryRepo->findByTitle("News","Tournois");
                },
                "label" => "Choisir une(des) catégorie(s)",
                "label_attr" => [
                    "class" => "form-control label",
                ],
                "attr" => [
                    "class" => "form-control input"
                ],
                "required" => true
            ])
            ->add("prioritaire", ChoiceType::class, [
                "choices" => [
                    "Non" => 0,
                    "Oui" => 1
                ],
                "label" => "Article à mettre en avant ?",
                "label_attr" => [
                    "class" => "form-control label",
                ],
                "attr" => [
                    "class" => "form-control input"
                ]
            ])
            ->add('photoArticles', FileType::class, [
                "required" => false,
                "label" => "photo",
                "multiple" => true
            ])
            ->addModelTransformer(new FilesToPicturesTransformer())
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
