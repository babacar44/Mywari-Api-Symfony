<?php

namespace App\Form;

use App\Entity\Compte;
use App\Entity\Operations;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RetraitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('CodeEnvoi')
            ->add('cniRecepteur')
            ->add('compte', EntityType::class,[
                'class' => Compte::class
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
