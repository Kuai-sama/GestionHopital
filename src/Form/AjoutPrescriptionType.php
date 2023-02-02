<?php

namespace App\Form;

use App\Entity\Medicament;
use App\Entity\Prescription;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AjoutPrescriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Unite')
            ->add('DateFin')
            ->add('date_debut')
            ->add('Status', ChoiceType::class,[
                'choices' => [
                    'A faire' => 'A faire',
                    'En cours de traitement' => 'En cours de traitement',
                    'Fini' => 'Fini',
                ]
            ])
            ->add('Medicament',EntityType::class,[
                'class' => Medicament::class, 'label' => 'Medicament'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Prescription::class,
        ]);
    }
}
