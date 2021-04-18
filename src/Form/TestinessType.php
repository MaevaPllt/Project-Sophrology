<?php

namespace App\Form;

use App\Entity\Testiness;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TestinessType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options):void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Prénom',
            ])
            ->add('age', TextType::class, [
                'label' => 'Age',
            ])
            ->add('date', DateType::class, [
                'label' => 'Date',
            ])
            ->add('content', CKEditorType::class, [
                'label' => 'Témoignage',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver):void
    {
        $resolver->setDefaults([
            'data_class' => Testiness::class,
        ]);
    }
}
