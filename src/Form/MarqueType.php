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
    use FormHelperTrait;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->addNomField($builder, $options);
        $this->addEtatField($builder, $options);
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
