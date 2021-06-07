<?php

namespace App\Form;

use App\Entity\Theme;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormTypeInterface;
use Vich\UploaderBundle\Form\Type\VichFileType;


class ThemeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('posterFile', VichFileType::class, [
                'label' => 'Image',
                'required' => false,
            ])
            ->add('name', TextType::class, [
                'label' => 'Thème d\'accompagnement',
            ])
            ->add('description', CKEditorType::class, [
                'label' => 'Contenu',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Theme::class,
        ]);
    }
}
