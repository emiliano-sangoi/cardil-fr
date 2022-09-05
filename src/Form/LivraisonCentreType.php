<?php

namespace App\Form;

use App\Entity\Fournisseur;
use App\Entity\LivraisonCentre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LivraisonCentreType extends AbstractType
{
    use FormHelperTrait;

    public function __construct()
    {
        $this->labelPrefix = 'form.livraison_centre.labels.';
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $this->addTextChild('nom', $builder);

        $builder
            ->add('latitude', NumberType::class, ['disabled' => true]);

        $builder
            ->add('longitude', NumberType::class, ['disabled' => true]);

        $builder
            ->add('cout');

        /*$builder
            ->add('fournisseur', EntityType::class, [
                'disabled' => true,
                'class' => Fournisseur::class
            ])
        ;*/

        $this->addEtatField($builder, $options);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LivraisonCentre::class,
            'attr' => [
                'id' => 'form_liv_centre',
                'class' => ''
            ]
        ]);
    }
}
