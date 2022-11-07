<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Entity\ResetPasswordRequest;
use App\Form\CreerCompteType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class SecurityController extends AbstractController
{
    #[Route('/oubliercompte', name: 'app_oubliercompte')]
    public function oublierCompte( EntityManagerInterface $em): Response
    {
        $compte = $em->getRepository(Personne::class)->find($this->getUser());

        $em->remove($compte);
        $em->flush();

        return $this->redirectToRoute('app_login');
    }

    #[Route('/supprimercompte', name: 'app_supprimercompte')]
    public function deleteCompte( EntityManagerInterface $em): Response
    {
       
        $user = $em->getRepository(Personne::class)->find($this->getUser());
        $this->container->get('security.token_storage')->setToken(null);

        $em->remove($user);
        $em->flush();
        
        $this->addFlash('message', 'Votre compte utilisateur a bien été supprimé !'); 

        return $this->redirectToRoute('app_login');
    }

    #[Route('/supprimerrequte/{id}', name: 'app_supprimerrequete')]
    public function deleterequete(int $id, EntityManagerInterface $em): Response
    {
        $compte = $em->getRepository(ResetPasswordRequest::class)->find($id);
        
        $em->remove($compte);
        $em->flush();

        return $this->redirectToRoute('app_login');
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/creercompte', name: 'app_creercomppte')]
    public function addCompte(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher): Response
    {
        $personne = new Personne();
        $personne->setRoles(['ROLE_PATIENT']);
        $form = $this->createForm(CreerCompteType::class, $personne);
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
        return $this->render('form/creerCompte.html.twig', ['form' => $form->createView()]);
    }


    #[Route('/adduser', name: 'app_security')]
    public function addUser(ManagerRegistry $doctrine, UserPasswordHasherInterface $passwordHasher): Response
    {
        $em = $doctrine->getManager();

        $user = new Personne();
        $user->setNumTel('0653278310')
            ->setNom('Patient1')
            ->setRoles(['ROLE_PATIENT'])
            ->setEmail('patient@gmail.com')
            ->setPrenom("Prenom")
            ->setNumSecuriteSociale('0654782145695214');

        $hashedPassword = $passwordHasher->hashPassword($user, '1234');
        $user->setPassword($hashedPassword);
        $em->persist($user);
        $em->flush();

        return $this->render("<body></body>");
    }

    #[Route(path: '/', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
