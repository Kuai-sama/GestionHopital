<?php

namespace App\Form;

use App\Entity\Lit;
use App\Entity\Personne;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModifierLitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('LitOccupe')
            ->add('salle')
            ->add('IdPersonne', EntityType::class, [
                'class' => Personne::class,
                'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('P')
                    ->where('P.idLit is null');
            }])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Lit::class,
        ]);
    }
}
