<?php

namespace App\Form;

use App\Entity\Porte;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PorteType extends AbstractType
{
    use FormHelperTrait;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->addNomField($builder, $options);
        $this->addEtatField($builder, $options);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Porte::class,
            'translator' => null,
            'attr' => [
                'id' => 'form_porte'
            ],
        ]);
    }
}
