<?php

namespace App\Form;

use App\Entity\Carrosserie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CarrosserieType extends AbstractType
{
    use FormHelperTrait;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->addNomField($builder, $options);

        $builder
            ->add('ordre');

        $this->addEtatField($builder, $options);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Carrosserie::class,
            'attr' => [
                'id' => 'form_carroseries'
            ],
        ]);
    }
}
