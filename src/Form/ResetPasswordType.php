<?php
namespace App\Form;

use App\Entity\ChangePassword;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResetPasswordType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('oldPassword', PasswordType::class, [
                "label" => "Ancien mot de passe",
                "label_attr" => [
                    "class" => "form-control label",
                ],
                "attr" => [
                    "placeholder" => "Votre ancien mot de passe",
                    "class" => "form-control input"
                ]
            ])
            ->add('newPassword', PasswordType::class, [
                "label" => "Nouveau mot de passe",
                "label_attr" => [
                    "class" => "form-control label",
                ],
                "attr" => [
                    "placeholder" => "Votre nouveau mot de passe",
                    "class" => "form-control input"
                ]
            ])
            ->add("confirm_newPassword", PasswordType::class, [
                "label" => "Confirmation nouveau mot de passe",
                "label_attr" => [
                    "class" => "form-control label",
                ],
                "attr" => [
                    "placeholder" => "Confirmer votre nouveau mot de passe",
                    "class" => "form-control input"
                ]
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            //mettre le nouveau formulaire
            'data_class' => ChangePassword::class,
            'csrf_token_id' => 'change_password',
        ));
    }
}