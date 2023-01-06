<?php

namespace App\Controller;

use App\Entity\RDV;
use App\Entity\Personne;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CalendarController extends AbstractController
{
    #[Route('/medecin/calendar', name: 'app_calendar')]
    public function view(EntityManagerInterface $em): Response
    {
        $events = $em->getRepository(RDV::class)->findAll();
        $rdvs = [];

        foreach ($events as $event) {
            # Calcul la date de fin de rendez-vous
            $end_date = new \DateTime($event->getDateHeure()->format('Y-m-d H:i:s'));
            $end_date->add(new \DateInterval('PT' . $event->getDuree() . 'M'));

            $Nom_patient = $em->getRepository(Personne::class)->find($event->getPersonne2()->getId())->getNom();
            $Prenom_patient = $em->getRepository(Personne::class)->find($event->getPersonne2()->getId())->getPrenom();

            $rdvs[] = [
                'id' => $event->getId(),
                'title' => $event->getTitre(),
                'start' => $event->getDateHeure()->format('Y-m-d H:i:s'),
                'end' => $end_date->format('Y-m-d H:i:s'),
                'duration_time' => $event->getDuree(),
                'description' => $event->getDescription(),
                'id_patient' => $event->getPersonne2()->getId(),
                'Nom_patient' => $Nom_patient,
                'Prenom_patient' => $Prenom_patient,
            ];
        }
        $data = json_encode($rdvs);
        return $this->render('medecin/index.html.twig', compact('data'));
    }
}
