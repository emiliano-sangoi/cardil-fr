<?php

namespace App\Form;

use App\Entity\Marque;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MarqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nomme',
                'label_attr' => [ 'class' => 'font-weight-bold']
                // 'help' => 'This field must be unique',
            ]);

        $builder
            ->add('etat', ChoiceType::class, [
                'label' => 'En ligne?',
                'label_attr' => [ 'class' => 'font-weight-bold'],
                'choices' => [
                    'Oui' => Marque::ETAT_OUI,
                    'Non' => Marque::ETAT_NON,
                ],
                'expanded' => true,
                'choice_attr' => ['class' => 'mx-5'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Marque::class,
            'attr' => [
                'id' => 'form_marque'
            ]
        ]);
    }
}
