<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Entity\RDV;
use App\Form\CreeComptePatientType;
use App\Repository\PersonneRepository;
use App\Repository\SalleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/ambulancier', name: 'app_')]
class AmbulancierController extends AbstractController
{
    #[Route('/', name: 'ambulancier')]
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

    #[Route('/ajoutcompte', name: 'ambulancier_ajoutcompte')]
    public function ajoutCompte(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher, PersonneRepository $compteExistant): Response
    {
        $personne = new Personne();
        $form = $this->createForm(CreeComptePatientType::class, $personne);
        $form->add('send', SubmitType::class, ['label' => 'Valider']);
        $form->handleRequest($request); // Alimentation du formulaire avec la Request

        if ($form->isSubmitted() && $form->isValid()) {

            $mailEntrer = $form->get('Email')->getData();

            $mailExistant = $compteExistant->MailCompte($mailEntrer);
            if($mailExistant == null)
            {
                $mdp = $personne->getPassword();
                $hashedPassword = $passwordHasher->hashPassword($personne, $mdp);
                $personne->setPassword($hashedPassword);
                $personne->setRoles(["ROLE_PATIENT"]);
                $em->persist($personne);
                $em->flush();

                $this->addFlash("info", "Le compte a été créé");

            }
            else
            {
                $this->addFlash("alert", "Le mail est déjà utilisé pour un autre compte");
            }
            return $this->redirectToRoute('app_ambulancier_ajoutcompte');
        }

        // Affichage du formulaire initial (requête GET) OU affichage du formulaire avec erreurs après validation (requête POST)
        return $this->render('ambulancier/formAjoutCompte.html.twig', ['form' => $form->createView()]);
    }
}
