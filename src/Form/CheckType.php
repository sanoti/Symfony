<?php

namespace App\Form;

use App\Entity\Check;
use App\Entity\Guest;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CheckType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateType::class, [
                'label' => "Дата",
                'widget' => 'choice',
                'placeholder' => [
                    'year' => 'Год', 'month' => 'Месяц', 'day' => 'День',
                ],
                'invalid_message' => 'Время введено некоректно'
            ])
            ->add('store', TextType::class, [
                'label' => "Магазин",
            ])
            ->add('byingGuest', EntityType::class, [
                'class' => Guest::class,
                'label' => 'Кто оплатил',
                'choice_label' => 'name',
                'placeholder' => 'Выберете гостя',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Check::class,
        ]);
    }
}
