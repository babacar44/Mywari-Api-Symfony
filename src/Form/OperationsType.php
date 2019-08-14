<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Operations;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Compte;

class OperationsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('CodeEnvoi')
            ->add('Envoyeur')
            ->add('Montant')
            ->add('Destinataire')
        
            // ->add('user', EntityType::class,[
            //     'class' => User::class
            // ])
            ->add('compte', EntityType::class,[
                'class' => Compte::class
            ])
            ->add('cniEnvoyeur')
            ->add('cniRecepteur')
            ->add('telEnvoyeur')
            ->add('telRecepteur')
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
