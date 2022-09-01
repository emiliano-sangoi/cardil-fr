<?php

namespace App\Form;

use App\Entity\Fournisseur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FournisseurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomCommercial')
            ->add('raisonSociale')
            ->add('adresse1')
            ->add('adresse2')
            ->add('codePostale')
            ->add('ville')
            ->add('tel')
            ->add('fax')
            ->add('email')
            ->add('siret')
            ->add('tvaIntraComm')
            ->add('tva')
            ->add('etat')
            ->add('emplacementFile')
            ->add('pays')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Fournisseur::class,
        ]);
    }
}
