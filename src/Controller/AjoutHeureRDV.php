<?php

namespace App\Controller;

use App\Entity\RDV;
use App\Entity\Salle;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class AjoutHeureRDV extends AbstractController
{

    #[Route('/listeRDV', name: 'listeRDV')]
    function view(EntityManagerInterface $em): Response
    {
        $id = $this->getUser()->getId();
        // On récupère tout les rdvs liés à l'utilisateur
        $events = $em->getRepository(RDV::class)->findRDVByMedecinOuInfermier($id);

        // On enlève tout les rendez-vous qui ont déjà une durée
        foreach ($events as $key => $event) {
            if ($event->getDuree() != null) {
                unset($events[$key]);
            }
        }
        return $this->render('Rdv/editRDV.html.twig', compact('events'));
    }

    #[Route('/ajoutHeureRDV', name: 'ajoutHeureRDV')]
    function add(EntityManagerInterface $em, Request $request): Response
    {
        // On récupère les données du formulaire
        $data = $request->request->all();

        // On vérifie que la salle existe
        if ($em->getRepository(Salle::class)->getByEmplacementSalle($data['salle']) == null) {
            $this->addFlash('alert', 'La salle n\'existe pas');

            return $this->redirectToRoute('listeRDV');
        }
        
        // On vérifie que la durée est bien un nombre et est comprise entre 15 et 55
        if (!is_numeric($data['duree']) || $data['duree'] < 15 || $data['duree'] > 55) {
            $this->addFlash('alert', 'La durée doit être un nombre compris entre 15 et 55');
            return $this->redirectToRoute('listeRDV');
        }
        // On récupère le rendez-vous et la salle
        $rdv = $em->getRepository(RDV::class)->find($data['id']);
        $salle = $em->getRepository(Salle::class)->getByEmplacementSalle($data['salle']);

        // On hydrate l'objet RDV
        $rdv->setTitre($data['titre']);
        $rdv->setDuree($data['duree']);
        $rdv->setSalle($salle);
        $rdv->setValider(true);

        // On enregistre les modifications
        $em->persist($rdv);

        // On envoie les modifications à la base de données
        $em->flush();

        $this->addFlash('info', 'Le rendez-vous a été modifié');
        return $this->redirectToRoute('listeRDV');
    }
}