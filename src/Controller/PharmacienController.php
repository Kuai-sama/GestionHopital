<?php

namespace App\Controller;

use App\Repository\MedicamentRepository;
use App\Repository\PrescriptionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PharmacienController extends AbstractController
{
    #[Route('/pharmacien', name: 'app_pharmacien')]
    public function index(): Response
    {
        return $this->render('pharmacien/index.html.twig', [
            'controller_name' => 'PharmacienController',
        ]);
    }

    #[Route('/traitement', name: 'app_traitement')]
    public function a_preparer(PrescriptionRepository $pres): Response
    {
        $prescriptions = $pres->To_prepare();

        return $this->render('pharmacien/traitement_a_faire.html.twig', [
            'Presciptions' => $prescriptions
        ]);
    }

    #[Route('/pret/{idprescription}', name: 'pret')]
    public function pret(MedicamentRepository $medoc,PrescriptionRepository $pres,$idprescription,EntityManagerInterface $en): Response
    {

        $prescription = $pres->findOneById($idprescription);
        $prescription->setStatus("En cours de traitement");
        $en->persist($prescription);
        $en->flush();

        $medicament = $medoc->findOneById($prescription->getMedicament());
        $stock = $medicament->getStock();
        $medicament->setStock($stock - $prescription->getUnite());
        $en->persist($medicament);
        $en->flush();

        return $this->redirectToRoute("app_traitement");
    }
}
