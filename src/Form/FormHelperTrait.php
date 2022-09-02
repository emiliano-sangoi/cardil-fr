<?php

namespace App\Form;


use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

trait FormHelperTrait
{

    public function addTextChild($child, FormBuilderInterface $builder, array $options = []){
        $options['label'] = 'form.fournisseur.labels.' . $child;

        $builder
            ->add($child, TextType::class, $options);
    }

    public function addEmailChild($child, FormBuilderInterface $builder, array $options = []){
        $options['label'] = 'form.fournisseur.labels.' . $child;

        $builder
            ->add($child, EmailType::class, $options);
    }

    public function addEtatField(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('etat', ChoiceType::class, [
                'label' => 'En ligne?',
                'choices' => [
                    'Oui' => 1,
                    'Non' => 2,
                ],
                'expanded' => true,
                'choice_attr' => ['class' => 'mx-5'],
            ]);
    }

    public function addNomField(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom',
                // 'help' => 'This field must be unique',
            ]);


    }

}
