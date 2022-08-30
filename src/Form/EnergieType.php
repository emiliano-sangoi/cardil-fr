<?php

namespace App\Form;

use App\Entity\Energie;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EnergieType extends AbstractType
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
                    'Oui' => 1,
                    'Non' => 2,
                ],
               'expanded' => true,
               'choice_attr' => ['class' => 'mx-5'],
               // 'attr' => [ 'class' => 'form-control' ]
            ]);

        /*$builder
            ->add('ordre')
        ;*/
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Energie::class,
            'attr' => [
                'id' => 'form_energie'
            ]
        ]);
    }
}