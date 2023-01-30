<?php

namespace App\Controller;

use App\Entity\RDV;
use App\Repository\PersonneRepository;
use App\Repository\SalleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AmbulancierController extends AbstractController
{
    #[Route('/ambulancier', name: 'app_ambulancier')]
    public function index(EntityManagerInterface $em, PersonneRepository $per,  SalleRepository $salle): Response
    {
        return $this->render('ambulancier/index.html.twig', [
            'controller_name' => 'AmbulancierController',
        ]);


        /*$rdv = new RDV();
        $rdv->setPersonne1($per->findOneById(20))->setPersonne2($per->findOneById(1))->setDateHeure(new \DateTime())->setSalle($salle->findOneById(1))->setDescription("Coup dans l'oeil")->setTitre("Examen occulaire")->setDuree(15);
        $em->persist($rdv);
        $em->flush();*/
    }
}
