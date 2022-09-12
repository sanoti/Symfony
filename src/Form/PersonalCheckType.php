<?php

namespace App\Form;

use App\Entity\Check;
use App\Entity\Guest;
use App\Entity\PersonalCheck;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonalCheckType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fromCheck', EntityType::class, [
                'class' => Check::class,
                'label' => 'Из чека',
                'choice_label' => 'id',
                'placeholder' => 'Выберете чек',
                'expanded' => true
            ])
            ->add('eatingProduct', EntityType::class, [
                'class' => Product::class,
                'label' => 'Продукт',
                'choice_label' => 'name',
                'placeholder' => 'Выберете продукт',
                'expanded' => true
    ])
            ->add('amount')
            ->add('guestWhoEat', EntityType::class, [
                'class' => Guest::class,
                'label' => 'Гость',
                'choice_label' => 'name',
                'placeholder' => 'Выберете гостя',
                'expanded' => true
    ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PersonalCheck::class,
        ]);
    }
}
