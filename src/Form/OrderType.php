<?php

namespace App\Form;

use App\Entity\Order;
use App\Entity\VehicleType;
use App\Form\VehicleTypeType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('latCoordinateStart', HiddenType::class)
            ->add('lngCoordinateStart',HiddenType::class)
            ->add('latCoordinateDestination', HiddenType::class)
            ->add('lngCoordinateDestination', HiddenType::class)
            ->add('vehicleType',EntityType::class,[
                'mapped' => false,
                'class' => VehicleType::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u');
                },
            ])
        ;


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}
