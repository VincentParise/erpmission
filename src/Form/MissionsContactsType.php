<?php

namespace App\Form;

use App\Entity\Contacts;
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

            ->add('contacts',EntityType::class,[
                'label'=>'Contact(s)',
                'multiple'=>true,
                'class'=>Contacts::class,
                'mapped'=>true,
                'required'=>true
                /*
                'query_builder'=> function(EntityRepository $entityRepository){
                    return $entityRepository->createQueryBuilder('u')
                        ->where('u.typeuser = 3'); //Type = 3 = Contact
                }*/
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Missions::class,
        ]);
    }
}
