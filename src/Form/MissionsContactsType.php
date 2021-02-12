<?php

namespace App\Form;

use App\Entity\Missions;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MissionsContactsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            /*
            ->add('users',EntityType::class,[
                'label'=>'Agent(s)',
                'required'=>true,
                'multiple'=>true,
                'class'=>User::class,
                'mapped'=>true,
                'query_builder'=> function(EntityRepository $entityRepository){
                    return $entityRepository->createQueryBuilder('u')
                        ->where('u.typeuser = 3'); //Type = 3 = Contact
                }
            ])*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Missions::class,
        ]);
    }
}
