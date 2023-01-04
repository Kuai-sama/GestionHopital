<?php

namespace App\Controller;

use App\Entity\Horaire;
use App\Repository\HoraireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints\DateTime;

#[Route('/horaire')]
class HoraireController extends AbstractController
{
    #[Route('/', name: 'app_horaire')]
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

    #[Route('/Adddebut', name: 'Add_debut')]
    public function addDebHoraire(EntityManagerInterface $em,UserInterface $user){
        $idP = $user->getId();
        $horaire = new Horaire();
        $horaire->setTdebut(new \DateTime())->setIdPersonne($idP);

        $em->persist($horaire);
        $em->flush();
    }

    #[Route('/Addfin', name: 'Add_fin')]
    public function addFinHoraire(HoraireRepository $horaireRepository,EntityManagerInterface $em,UserInterface $user){
        $idP = $user->getId();
        $horaire = $horaireRepository->findOneBy($idP);
        $horaire->setTfin(new \DateTime());

        $em->persist($horaire);
        $em->flush();
    }
}
