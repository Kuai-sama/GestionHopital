<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Service\CodeReminder;
use App\Repository\LitRepository;
use App\Repository\PatientRepository;
use App\Repository\PersonneRepository;
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
    public function verification_code(CodeReminder $code_retenue, PatientRepository $patient, LitRepository $lit,PersonneRepository $roles ,ManagerRegistry $doctrine): Response
    {
        $request = Request::createFromGlobals();
        $idMed = $request->request->get('medecin');
        if($idMed != null || $idMed != "")
        {
            $assigner = true;
            dump($idlit = $request->request->get('lit'));
            dump($litpatient = $request->request->get('personne'));
        }
        else
        {
            $assigner = false;
            $code = $request->request->get('code');
            //$this->setParameter('code_retenue', $code);
            $code_retenue->setCode($code);
            if($code == null || $code == "") // cas de code vide
            {
                return $this->render('infirmier/verifcode.html.twig', ['salle' => null]);
            }
        }
        //dump($this->getParameter('code_retenue'));
        dump($code_retenue->getCode());

        //$idpatient = $patient->findOneBy(['code_entre' => $this->getParameter('code_retenue')]);
        $idpatient = $patient->findOneBy(['code_entre' => $this->getParameter('code_retenue')]);

        if($idpatient == null) // case de code invalide
        {
            return $this->render('infirmier/verifcode.html.twig', ['salle' => "introuvable"]);
        }
        
        $em = $doctrine->getManager();
        $personne = $idpatient->getPersonne();
        $IdPersonne = $personne->getId();
        $salle = $lit->findSalle($IdPersonne);
        if($assigner == false)
        {
            $litpatient = $lit->findOneBy(['salle'=> $salle])->getId();
            $medecin = $roles->findMedecin();
            $Praison = $idpatient->getRaison();
            return $this->render('infirmier/assignemedecin.html.twig',['lit'=> $litpatient, 'medecin' => $medecin, 'personne'=> $personne, 'salle' => $salle, 'raison'=>$Praison]);
        }
        

        //$idpatient->setCodeEntre(null);
        //$em->flush();

        return $this->render('infirmier/verifcode.html.twig', ['salle' => $salle, 'patient'=>$personne]);
    }






}
