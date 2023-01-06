<?php

namespace App\Controller;

use App\Entity\Patient;
use App\Entity\Personne;
use App\Service\CodeReminder;
use App\Repository\LitRepository;
use App\Repository\PatientRepository;
use App\Repository\PersonneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Constraints\DateTime;


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
    public function verification_code(PatientRepository $patients, LitRepository $lit,PersonneRepository $roles ,ManagerRegistry $doctrine, EntityManagerInterface $em): Response
    {
        $request = Request::createFromGlobals();
        $idMed = $request->request->get('medecin');
        $code = $request->request->get('code');

        if($idMed != null || $idMed != "")
        {
            $assigner = true;
            $raison = $request->request->get('raison');
            dump($idMed);
            dump($raison);
            dump($code);
        }
        else
        {
            $assigner = false;
            if($code == null || $code == "") // cas de code vide
            {
                return $this->render('infirmier/verifcode.html.twig', ['salle' => null]);
            }
        }


        $Patient = $patients->findOneBy(['code_entre' => $code]);

        if($patients == null) // case de code invalide
        {
            return $this->render('infirmier/verifcode.html.twig', ['salle' => "introuvable"]);
        }

        $em = $doctrine->getManager();
        $personne = $Patient->getPersonne();
        $IdPersonne = $personne->getId();
        $salle = $lit->findSalle($IdPersonne);
        if($assigner == false)
        {
            $medecin = $roles->PersonneMedecin();
            return $this->render('infirmier/assignemedecin.html.twig',[ 'medecin' => $medecin, 'personne'=> $personne, 'salle' => $salle, 'code'=>$code]);
        }

        $litpatient = $lit->findOneBy(['salle'=> $salle])->getId();

        $Patient->setRaison($raison);
        $medecin = $em->getRepository(Personne::class)->findOneBy(['id' => $idMed]);
        dump($medecin);
        $medecin->setPatient($Patient);
        $Patient->setDateHeureEntree(new \DateTime());
        $Patient->setCodeEntre(null);

        $em->persist($medecin);
        $em->persist($Patient);
        $em->flush();

        return $this->render('infirmier/verifcode.html.twig', ['salle' => $salle, 'patient'=>$personne]);
    }






}
