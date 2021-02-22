<?php

namespace App\Form;


use App\Entity\Missions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MissionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('codename')
            ->add('datestart',DateType::class,[
                'widget'=>'single_text'
            ])
            ->add('dateend',DateType::class,[
                'widget'=>'single_text'
            ])
            ->add('typemission')
            ->add('statutmission')
            ->add('paysmission')
            ->add('specialitemission')

            /*->add('cibles',EntityType::class,[
                'class'=>Cibles::class,
                'mapped'=>false
            ])
            ->add('planques',EntityType::class,[
                'class'=>Planques::class,
                'mapped'=>false,
                'query_builder'=> function(EntityRepository $entityRepository){
                    return $entityRepository->createQueryBuilder('p')
                        ->where('p.paysplanque = 2');
                }
            ])
            ->add('users',EntityType::class,[
                'label'=>'Agent(s)',
                'required'=>true,
                'multiple'=>true,
                'class'=>User::class,
                'query_builder'=> function(EntityRepository $entityRepository){
                    return $entityRepository->createQueryBuilder('u')
                            ->where('u.typeuser = 3');
                }
            ])
            ->add('users',EntityType::class,[
                'label'=>'Contact(s)',
                'required'=>true,
                'multiple'=>true,
                'class'=>User::class,
                'query_builder'=> function(EntityRepository $entityRepository){
                    return $entityRepository->createQueryBuilder('u')
                        ->where('u.typeuser = 2');
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
