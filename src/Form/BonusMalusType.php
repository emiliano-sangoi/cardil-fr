<?php

namespace App\Form;

use App\Entity\BonusMalus;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BonusMalusType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('minCO2', NumberType::class, [
                'label' => 'Min. CO2 (g/Km)'
            ]);

        $builder
            ->add('maxCO2', NumberType::class, [
                'label' => 'Max. CO2 (g/Km)'
            ]);

        $builder
            ->add('montant', NumberType::class, [
                'label' => 'Montant (€)'
            ]);

        $builder
            ->add('lettre');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BonusMalus::class,
            'translator' => null,
            'attr' => [
                'id' => 'form_bonus_malus'
            ]
        ]);
    }
}
