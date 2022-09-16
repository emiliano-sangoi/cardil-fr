<?php

namespace App\Form;

use App\Entity\BoiteDeVitesse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BoiteDeVitesseType extends AbstractType
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
            'data_class' => BoiteDeVitesse::class,
            'attr' => [
                'id' => 'form_boite_de_vitesses'
            ],
        ]);
    }
}
