<?php

namespace App\Form;

use App\Entity\Repport;
use App\Entity\User;
use App\Repository\UserRepository;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RepportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('number', IntegerType::class, [
                'label' => 'Numéro de compte-rendu',
            ])
            ->add('message', CKEditorType::class, [
                'label' => 'Contenu',
            ])
            ->add('date', DateType::class, [
                'label' => 'Date de la séance',
            ])
            ->add('patient', EntityType::class, [
                'class' => User::class,
                'choice_label' => function (User $user) {
                    return $user->getLastname() . ' ' . $user->getFirstname();
                },
                'query_builder' => function (UserRepository $userRepository)
                    {
                        return $userRepository->createQueryBuilder('u')
                            ->Where('u.roles NOT LIKE :role')
                            ->setParameter('role', '%' . 'ROLE_ADMIN' . '%')
                            ->orderBy('u.lastname', 'ASC');
                    },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Repport::class,
        ]);
    }
}
