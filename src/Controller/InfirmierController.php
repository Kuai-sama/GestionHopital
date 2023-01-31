<?php

namespace App\Controller;

use App\Entity\Patient;
use App\Entity\Personne;
use App\Service\CodeReminder;
use App\Repository\LitRepository;
use App\Repository\PatientRepository;
use App\Repository\ServiceRepository;
use App\Repository\PersonneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/infirmier', name: 'infirmier_')]
class InfirmierController extends AbstractController
{
    #[Route('/accueil', name: 'accueil')]
    public function index(): Response
    {
        return $this->render('infirmier/index.html.twig', [
            'controller_name' => 'InfirmierController',
        ]);
    }
    /*public function index(): Response
    {
        return $this->render('infirmier/creerCompteAdmin.html.twig', [
            'controller_name' => 'InfirmierController',
        ]);
    }*/

    #[Route('/verification_code', name: 'verification_code')]
    public function verification_code(PatientRepository $patients, LitRepository $lit,PersonneRepository $roles ,ManagerRegistry $doctrine, EntityManagerInterface $em, ServiceRepository $service): Response
    {
        $request = Request::createFromGlobals();
        $code = $request->request->get('code');
        $services = $request->request->get('service');

        if($services != null || $services != "")
        {
            $assigner = true;
            $raison = $request->request->get('raison');
            
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
            $services = $service->findAll();
            return $this->render('infirmier/assignemedecin.html.twig',[ 'personne'=> $personne, 'salle' => $salle, 'code'=>$code, 'services'=>$services]);
        }

        $litpatient = $lit->findOneBy(['salle'=> $salle])->getId();
        $idservice = $service->findOneBy(['id' => $services]);

        $Patient->setRaison($raison);
        $Patient->setDateHeureEntree(new \DateTime());
        $Patient->setCodeEntre(null);
        $Patient->setService($idservice);

        $em->persist($Patient);
        $em->flush();

        return $this->render('infirmier/verifcode.html.twig', ['salle' => $salle, 'patient'=>$personne]);
    }






}
