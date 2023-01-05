<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\Personne;
use App\Entity\Salle;
use App\Repository\PersonneRepository;
use App\Repository\SalleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BipperController extends AbstractController
{

    #[Route('/liste_medecins', name: 'app_bipper_liste')]
    public function liste(EntityManagerInterface $em): Response
    {
        $medecin = $em
            ->getRepository(Personne::class)->PersonneMedecin();

        $infirmier = $em
            ->getRepository(Personne::class)->PersonneInfirmier();

        return $this->render('bipper/affichePersonnel.html.twig', ['medecins' => $medecin, 'infirmiers' => $infirmier]);
    }

    #[Route('/salle/{idReceveur}', name: 'app_bipper_salle')]
    public function message(EntityManagerInterface $em, int $idReceveur): Response
    {
        $salle = $em
            ->getRepository(Salle::class)->findAll();

        //dump($salle);

        return $this->render('bipper/afficheSalle.html.twig', ['salles' => $salle, 'idReceveur' => $idReceveur]);
    }

    #[Route('/bipper/{idEnvoyeur}/{idReceveur}/{idSalle}', name: 'app_bipper_valide_bippe')]
    public function valideBippe(int $idEnvoyeur, int $idReceveur, int $idSalle, EntityManagerInterface $em): Response
    {
        $infoReceveur =$em->getRepository(Personne::class)->findOneBy(['id' => $idReceveur]);
        $infoSalle =$em->getRepository(Salle::class)->findOneBy(['id' => $idSalle]);

        return $this->render('bipper/validerBipper.html.twig', ['salle' => $infoSalle, 'receveur' => $infoReceveur,
            'idSalles' => $idSalle, 'idReceveur' => $idReceveur, 'idEnvoyeur' => $idEnvoyeur]);
    }

    #[Route('/enregistrer/{idEnvoyeur}/{idReceveur}/{idSalle}', name: 'app_bipper_enregistre_bippe')]
    public function EnregistreBippe(PersonneRepository $Envoyeur,PersonneRepository $Receveur,SalleRepository $salle ,int $idEnvoyeur, int $idReceveur, int $idSalle, EntityManagerInterface $em): Response
    {

        $message = new Message();
        $message->setPersonne1($Envoyeur->findOneById($idEnvoyeur))->setPersonne2($Receveur->findOneById($idReceveur))->setSalle($salle->findOneById($idSalle));
        $em->persist($message);
        $em->flush();

        $user = $this->getUser()->getRoles();
        if ($user[0] == "ROLE_MEDECIN")
        {
            return $this->redirectToRoute("app_medecin");
        }
        else
        {
            return $this->redirectToRoute("app_infirmier");
        }
    }

    /* -------------------------------------------------------------------------------------------------------------- */

    #[Route('/affiche/notif', name: 'app_bipper_affiche_notif')]
    public function AfficherBippes(EntityManagerInterface $em): Response
    {
        $user = $this->getUser()->getId();
        //$notif = $em->getRepository(Message::class)->findBy(['Personne2' => $user]);
        $notif = $em->getRepository(Message::class)->findNotif($user);

        //dump($user);
        //dump($notif);

        return $this->render('bipper/afficheBipperPerso.html.twig', ['notifs' => $notif]);
    }

    #[Route('/fini/notif/{id}', name: 'app_bipper_fini_notif')]
    public function notifFini(int $id, EntityManagerInterface $em): Response
    {
        return $this->render('bipper/confirmationNotifFini.html.twig', ['id' => $id]);
    }

    #[Route('/delete/notif/{id}', name: 'app_bipper_delete_notif')]
    public function deleteNotif(int $id, EntityManagerInterface $em): Response
    {
        $message = $em->getRepository(Message::class)->findOneById($id);

        $em->remove($message);
        $em->flush();


        dump($message);

        return $this->redirectToRoute("app_bipper_affiche_notif");
    }
}
