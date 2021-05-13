<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Event;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Titre de l\'actualité',
            ])
            ->add('date', DateType::class, [
                'label' => 'Date de l\'actualité',
                'format' => 'dd-MM-yyyy',
            ])
            ->add('resume', CKEditorType::class, [
                'label' => 'Résumé',
            ])
            ->add('posterFile', VichImageType::class, [
                'label' => 'Image',
            ])
            ->add('content', CKEditorType::class, [
                'label' => 'Contenu de l\'actualité',
            ])
            ->add('category', EntityType::class, [
                'label' => 'Categorie',
                'class' => Category::class,
                'choice_label' => 'name',
            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
