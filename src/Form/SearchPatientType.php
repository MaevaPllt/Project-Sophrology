<?php

namespace App\Form;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchPatientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', EntityType::class, [
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

            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
