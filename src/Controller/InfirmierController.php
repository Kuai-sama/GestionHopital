<?php

namespace App\Controller;

use App\Repository\LitRepository;
use App\Repository\PatientRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/infirmier', name: 'infirmier_')]
class InfirmierController extends AbstractController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('infirmier/creerCompteAdmin.html.twig', [
            'controller_name' => 'InfirmierController',
        ]);
    }

    #[Route('/verification_code', name: 'verification_code')]
    public function verification_code(PatientRepository $patient, LitRepository $lit,ManagerRegistry $doctrine): Response
    {
        $request = Request::createFromGlobals();
        $code = $request->request->get('code');
        if($code == null || $code == "") // cas de code vide
        {
            return $this->render('infirmier/verifcode.html.twig', ['salle' => null]);
        }
        $idpatient = $patient->findOneBy(['code_entre' => $code]);
        if($idpatient == null) // case de code invalide
        {
            return $this->render('infirmier/verifcode.html.twig', ['salle' => "introuvable"]);
        }
        $em = $doctrine->getManager();
        $personne = $idpatient->getPersonne();
        // $NomPersonne = $personne->getNom();
        // $PrenomPersonne = $personne->getPrenom();
        $IdPersonne = $personne->getId();
        $salle = $lit->findSalle($IdPersonne);
        $idpatient->setCodeEntre(null);
        $em->flush();

        return $this->render('infirmier/verifcode.html.twig', ['salle' => $salle, 'patient'=>$personne]);
    }






}
