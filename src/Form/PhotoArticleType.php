<?php
namespace App\Form;

use App\Entity\PhotoArticle;
use App\Form\FilesToPicturesTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PhotoArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imageFile', FileType::class, [
                "label" => "Votre image",
                "label_attr" => [
                    "class" => "form-control label",
                ],
                "attr" => [
                    "class" => "form-control input"
                ],
                'row_attr' => [
                    'class' => 'divFormPhoto',
                ],
                "required" => false,
                "multiple" => true
            ])
            ->addModelTransformer(new FilesToPicturesTransformer())
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PhotoArticle::class,
        ]);
    }
}