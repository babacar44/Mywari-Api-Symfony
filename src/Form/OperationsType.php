<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Operations;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OperationsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('CodeEnvoi')
            ->add('Envoyeur')
            ->add('Montant')
            ->add('commission')
            ->add('Destinataire')
            ->add('CNI')
            ->add('user', EntityType::class,[
                'class' => User::class
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Operations::class,
            'csrf_protection'=>false
        ]);
    }
}
