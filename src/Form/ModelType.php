<?php

namespace App\Form;

use App\Entity\Marque;
use App\Entity\Model;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class ModelType extends AbstractType
{
    private TranslatorInterface $translator;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->translator = $options['translator'];

        $builder
            ->add('nom', TextType::class, [
                'label' => $this->translator->trans('Name'),
                'label_attr' => [ 'class' => 'font-weight-bold']
                // 'help' => 'This field must be unique',
            ]);

        $builder
            ->add('etat', ChoiceType::class, [
                'label' => $this->translator->trans('Online'),
                'label_attr' => [ 'class' => 'font-weight-bold'],
                'choices' => [
                    'Oui' => Model::ETAT_OUI,
                    'Non' => Model::ETAT_NON,
                ],
                'expanded' => true,
                'choice_attr' => ['class' => 'mx-5'],
            ]);


        $builder
            ->add('typeTransport', TextType::class, [
                'label' => $this->translator->trans('Transport type'),
                'label_attr' => [ 'class' => 'font-weight-bold'],
            ]);

        $builder
            ->add('marque', EntityType::class, [
                'class' => Marque::class,
                'disabled' => $options['marque_selector_disabled']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Model::class,
            'attr' => [
                'id' => 'form_model'
            ],
            'translator' => null,
            'marque_selector_disabled' => false
        ]);
    }
}
