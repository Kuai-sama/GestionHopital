<?php

namespace App\Controller;

use App\Entity\Horaire;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints\DateTime;

class HoraireController extends AbstractController
{
    #[Route('/horaire', name: 'app_horaire')]
    public function index(UserInterface $user): Response
    {
        //$userId = $user->getId();
        //$time = date('H:i:s d/m/Y').datetime;
        //$date = new \DateTime('@'.strtotime('now'));
        //dump($date);

        return $this->render('horaire/index.html.twig', [
            'controller_name' => 'HoraireController',
        ]);
    }

    public function addHoraire(EntityManagerInterface $em, integer $idP){
        $horaire = new Horaire();
        $horaire->setTdebut(new \DateTime())->setIdPersonne($idP);
    }
}
