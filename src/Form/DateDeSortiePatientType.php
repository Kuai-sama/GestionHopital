<?php

namespace App\Form;

use App\Entity\Patient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DateDeSortiePatientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Récupère la date d’aujourd’hui
        $date = new \DateTime('now');
        // On enlève les secondes
        $date->setTime($date->format('H'), $date->format('i'), 0);
        $builder
            ->add('DateHeureSortie',DateTimeType::class, [
                'widget' => 'single_text',
                'with_seconds' => false,
                'data' => $date,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Patient::class,
        ]);
    }
}
