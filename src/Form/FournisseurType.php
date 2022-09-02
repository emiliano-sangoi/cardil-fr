<?php
/**
 * https://www.elao.com/blog/dev/a-nice-way-of-handing-form-label-translation
 */

namespace App\Form;

use App\Entity\Fournisseur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FournisseurType extends AbstractType
{
    use FormHelperTrait;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->addTextChild('nomCommercial', $builder);
        $this->addTextChild('raisonSociale', $builder);
        $this->addTextChild('adresse1', $builder);
        $this->addTextChild('adresse2', $builder);


        $builder
            ->add('codePostale')
            ->add('ville')
            ->add('tel')
            ->add('fax');

        $this->addEmailChild('email', $builder);

        $builder
            ->add('siret')
            ->add('tvaIntraComm')
            ->add('tva')
            //->add('emplacementFile')
            ->add('pays')
        ;

        $this->addEtatField($builder, $options);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Fournisseur::class,
            'attr' => [
                'id' => 'form_fournisseur'
            ]
        ]);
    }
}
