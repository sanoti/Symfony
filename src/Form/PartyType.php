<?php

namespace App\Form;

use App\Entity\Guest;
use App\Entity\Party;
use phpDocumentor\Reflection\Types\AbstractList;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PartyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => "Название",
            ])

            ->add('dateAt', DateType::class, [
                'label' => "Дата",
                'widget' => 'choice',
                'placeholder' => [
                    'year' => 'Год', 'month' => 'Месяц', 'day' => 'День',
                ],
                'invalid_message' => 'Время введено некоректно'
            ])

            ->add('location', TextType::class, [
                'label' => "Место\nпроведения",
                ])

            ->add('guests', EntityType::class, [
                'class' => Guest::class,
                'label' => 'Гости',
                'choice_label' => 'name',
                'placeholder' => 'Выберете гостей',
                'multiple' => true,
                'expanded' => true,
            ])




        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Party::class,
        ]);
    }
}
