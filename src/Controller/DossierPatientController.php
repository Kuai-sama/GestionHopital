<?php

namespace App\Controller;

use App\Repository\PatientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DossierPatientController extends AbstractController
{
    #[Route('/dossier/{idpatient}', name: 'app_dossier_patient')]
    public function index($idpatient, PatientRepository $patient): Response
    {
        dump($patient->getPatInfo($idpatient));

        return $this->render('dossier_patient/index.html.twig', [
            'InfoPatient' => $patient->getPatInfo($idpatient),
        ]);
    }
}
