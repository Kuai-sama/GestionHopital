<?php

namespace App\Form;

use App\Entity\Medicament;
use App\Entity\Prescription;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AjoutPrescriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Récupère la date d’aujourd’hui
        $date = new \DateTime('now');
        // On enlève les secondes
        $date->setTime($date->format('H'), $date->format('i'), 0);

        $builder
            ->add('Unite')
            ->add('DateFin',DateTimeType::class, [
                'widget' => 'single_text',
                'with_seconds' => false,
                'data' => $date,
            ])
            ->add('date_debut',DateTimeType::class, [
                'widget' => 'single_text',
                'with_seconds' => false,
                'data' => $date,
            ])
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
