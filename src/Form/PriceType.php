<?php

namespace App\Form;

use App\Entity\Price;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PriceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du tarif',
            ])
            ->add('price', TextType::class, [
                'label' => 'Prix',
            ])
            ->add('information', TextareaType::class, [
                'label' => 'Informations complémentaires (type de séances, durée...)'
            ])
            ->add('description', CKEditorType::class, [
                'label' => 'Description de la séance',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Price::class,
        ]);
    }
}
