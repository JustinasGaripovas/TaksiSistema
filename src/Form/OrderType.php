<?php

namespace App\Form;

use App\Entity\Order;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('basePrice')
            ->add('additionalPrice')
            ->add('driverRating')
            ->add('passengerRating')
            ->add('driver')
            ->add('latCoordinateStart', HiddenType::class)
            ->add('lngCoordinateStart',HiddenType::class)
            ->add('latCoordinateDestination', HiddenType::class)
            ->add('lngCoordinateDestination',HiddenType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}
