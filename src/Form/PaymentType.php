<?php

namespace App\Form;

use App\Entity\Guest;
use App\Entity\Payment;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PaymentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateTimeType::class, [
                'label' => "Дата",
                'widget' => 'choice',
                'placeholder' => [
                    'year' => 'Год', 'month' => 'Месяц', 'day' => 'День',
                    'hour' => 'Часы', 'minute' => 'Минуты',
                ],
                'invalid_message' => 'Время введено некоректно'
            ])
            ->add('sum', MoneyType::class, [
                'label' => 'Сумма',
                'currency' => 'USD'
            ])
            ->add('fromGuest', EntityType::class, [
                'class' => Guest::class,
                'label' => 'Отправитель',
                'choice_label' => 'name',
                'placeholder' => 'Выберете продукты',
                'expanded' => true
            ])
            ->add('toGuest', EntityType::class, [
                'class' => Guest::class,
                'label' => 'Получатель',
                'choice_label' => 'name',
                'placeholder' => 'Выберете продукты',
                'expanded' => true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Payment::class,
        ]);
    }
}
