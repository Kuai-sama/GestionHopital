<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Form\CreerCompteAdminType;
use App\Repository\HoraireRepository;
use App\Repository\PersonneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function ajoutCompte(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher): Response
    {
        $personne = new Personne();
        $form = $this->createForm(CreerCompteAdminType::class, $personne);
        $form->add('send', SubmitType::class, ['label' => 'Valider']);
        $form->handleRequest($request); // Alimentation du formulaire avec la Request

        if ($form->isSubmitted() && $form->isValid()) {
            $mdp = $personne->getPassword();
            $hashedPassword = $passwordHasher->hashPassword($personne, $mdp);
            $personne->setPassword($hashedPassword);
            $em->persist($personne);
            $em->flush();

            return $this->redirectToRoute('app_login');
        }

        // Affichage du formulaire initial (requête GET) OU affichage du formulaire avec erreurs après validation (requête POST)
        return $this->render('admin/creerCompteAdmin.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/admin/checkHoraire', name: 'app_admin_checkHoraire')]
    public function checkHorairePersonnel(HoraireRepository $horaire){
        return $this->render('admin/horaireCheck.html.twig',
            ['horaires' => $horaire->getPersonneHoraire()]);
    }

    #[Route('/admin/affichercompte', name: 'app_admin_affichercompte')]
    public function affichercompte(EntityManagerInterface $em){
        $infirmier = $em->getRepository(Personne::class)->PersonneInfirmier();
        $medecin = $em->getRepository(Personne::class)->PersonneMedecin();

        return $this->render('admin/affichercompte.html.twig',
            ['medecins' => $medecin, 'infirmiers' => $infirmier]);
    }

    #[Route('/admin/valide/deletecompte/{id}', name: 'app_admin_valide_delete_compte')]
    public function validedeletecompte(int $id, EntityManagerInterface $em){

        $compte = $em->getRepository(Personne::class)->findOneById($id);

        return $this->render('admin/validerDelete.html.twig',
            ['compte' => $compte]);
    }

    #[Route('/admin/deletecompte/{id}', name: 'app_admin_delete_compte')]
    public function deletecompte(int $id, EntityManagerInterface $em){

        $personne = $em->getRepository(Personne::class)->findOneById($id);

        $em->remove($personne);
        $em->flush();

        return $this->redirectToRoute("app_admin_affichercompte");
    }
}
