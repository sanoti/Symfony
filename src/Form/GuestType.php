<?php

namespace App\Form;

use App\Entity\Guest;
use App\Entity\Party;
use App\Entity\Payment;
use App\Entity\PersonalCheck;
use App\Entity\Product;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;

class GuestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => "Имя",
            ])
            ->add('number', TelType::class, [
                'label' => "Номер",
                'invalid_message' => "Неверный формат номера",
            ])
            ->add('parties', EntityType::class, [
                'class' => Party::class,
                'label' => 'Вечеринки',
                'choice_label' => 'name',
                'placeholder' => 'Выберете вечеринку',
                'multiple' => true,
                'expanded' => true
            ])
            ->add('whoUser', EntityType::class, [
                'class' => User::class,
                'label' => 'Пользователь',
                'choice_label' => 'email',
                'placeholder' => 'Выберете пользователя',
                'expanded' => true
            ])



        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Guest::class,
        ]);
    }
}
