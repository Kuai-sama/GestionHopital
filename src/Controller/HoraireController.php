<?php

namespace App\Controller;

use App\Entity\Horaire;
use App\Repository\HoraireRepository;
use App\Repository\PersonneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints\DateTime;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/horaire')]
//[IsGranted('ROLE_MEDECIN')]
//[IsGranted('ROLE_INFIRMIER')]
#[Security("is_granted('ROLE_INFIRMIER') or is_granted('ROLE_MEDECIN')")]
class HoraireController extends AbstractController
{
    #[Route('/', name: 'app_horaire')]
    public function index(UserInterface $user,HoraireRepository $horaireRepository): Response
    {
        $EnService = false;
        $userId = $user->getId();
        //$time = date('H:i:s d/m/Y').datetime;
        //$date = new \DateTime('@'.strtotime('now'));
        //dump($date);

        if($horaireRepository->getHoraireWithoutEnd($userId) == null){
            $EnService = true;
        }

        return $this->render('horaire/index.html.twig', [
            'bool1' => $EnService,
        ]);
    }

    #[Route('/Adddebut', name: 'Add_debut')]
    public function addDebHoraire(PersonneRepository $personne,EntityManagerInterface $em,UserInterface $user){
        $idP = $user->getId();
        $horaire = new Horaire();
        $horaire->setTdebut(new \DateTime())->setIdPersonne($personne->findOneById($idP));

        $em->persist($horaire);
        $em->flush();

        return $this->redirectToRoute('app_horaire');
    }

    #[Route('/Addfin', name: 'Add_fin')]
    public function addFinHoraire(PersonneRepository $personne,HoraireRepository $horaireRepository,EntityManagerInterface $em,UserInterface $user){
        $idP = $user->getId();
        $horaire = $horaireRepository->getHoraireWithoutEnd($idP);
        dump($horaire);
        $horaire[0]->setTfin(new \DateTime());

        $em->persist($horaire[0]);
        $em->flush();

        return $this->redirectToRoute('app_horaire');
    }
}
