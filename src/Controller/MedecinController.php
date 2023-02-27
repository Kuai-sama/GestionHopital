<?php

namespace App\Controller;

use App\Entity\Patient;
use App\Entity\Service;
use App\Repository\PatientRepository;
use App\Repository\PersonneRepository;
use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MedecinController extends AbstractController
{
    #[Route('/medecin', name: 'app_medecin')]
    #[Security("is_granted('ROLE_MEDECIN')")]
    public function index(): Response
    {
        return $this->render('medecin/index.html.twig', [
            'controller_name' => 'MedecinController',
        ]);
    }

    #[Route('/listePatient',name: "list_patient")]
    #[Security("is_granted('ROLE_INFIRMIER') or is_granted('ROLE_MEDECIN')")]
    public function listePat(PatientRepository $patient,PersonneRepository $per, ServiceRepository $ser, EntityManagerInterface $en): Response
    {
        $idUserSer = $per->find($this->getUser())->getService()->getId();

        /*$pat = new Patient();
        $pat->setService($ser->findOneById(1))->setPersonne($per->findOneById(2))->setRaison("mal de gorge")->setDateHeureEntree(new \DateTime());
        $en->persist($pat);
        $en->flush();*/

        return $this->render('patient/listPat.html.twig', [
            'patients' => $patient->getPatPer($idUserSer),
        ]);
    }
}
