<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Partenaire;
use Symfony\Component\Form\AbstractType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Compte;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            // ->add('roles')
            ->add('password')
            ->add('nomComplet')
            ->add('propriete')
            ->add('adresse')
            ->add('telephone')
            ->add('statut')
            ->add('imageFile', VichFileType::class) 
            ->add('profil') 
            ->add('partenaire',EntityType::class,[
                'class' => Partenaire::class,
            ])
            ->add('compte',EntityType::class,[
                'class' => Compte::class,
            ])
            

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'csrf_protection'=>false
        ]);
    }
}
