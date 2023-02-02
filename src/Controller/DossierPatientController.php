<?php

namespace App\Controller;

use App\Entity\AppliquerPrescription;
use App\Entity\Diagnostic;
use App\Entity\Personne;
use App\Entity\Prescription;
use App\Form\AjoutDiagnosticType;
use App\Form\AjoutPrescriptionType;
use App\Form\DateDeSortiePatientType;
use App\Form\PatientType;
use App\Form\ServicePatientType;
use App\Repository\AppliquerPrescriptionRepository;
use App\Repository\PatientRepository;
use App\Repository\PersonneRepository;
use App\Repository\PrescriptionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DossierPatientController extends AbstractController
{
    #[Route('/dossier/{idpatient}', name: 'app_dossier_patient')]
    public function index($idpatient, PatientRepository $patient, AppliquerPrescriptionRepository $prescription): Response
    {
        //dump($patient->getPatInfo($idpatient));
        dump($patient->findOneById($idpatient)->getPersonne()->getId());

        return $this->render('dossier_patient/index.html.twig', [
            'InfoPatient' => $patient->getPatInfo($idpatient),
            'DejaPrescri' => $prescription->prescriptionDejaRealiser($patient->findOneById($idpatient)->getPersonne()->getId()),
            'Presciption' => $prescription->getPrescirption($patient->findOneById($idpatient)->getPersonne()->getId())
        ]);
    }

    #[Route('/dossier/date_de_sortie/{idpatient}', name: 'dossier_date_sortie')]
    public function dateSortieForm($idpatient, PatientRepository $patient,Request $request,EntityManagerInterface $en): Response
    {
        $personne = $patient->findOneById($idpatient);
        $form = $this->createForm(DateDeSortiePatientType::class,$personne);
        $form->add('send',SubmitType::class,['label'=>'modifier/ajouter une date de sortie pour ce patient']);
        $form->handleRequest($request);



        if(($form->isSubmitted() && $form->isValid())){
            //form
            $en->persist($personne);
            $en->flush();
            //message
            $this->addFlash('info','ajout réussi');

            return $this->redirectToRoute('list_patient');
        }

        return $this->render('dossier_patient/dateSortieForm.html.twig',['form'=>$form->createView()]);
    }

    #[Route('/dossier/service/{idpatient}', name: 'dossier_service')]
    public function ServiceForm($idpatient, PatientRepository $patient,Request $request,EntityManagerInterface $en): Response
    {
        $personne = $patient->findOneById($idpatient);
        $form = $this->createForm(ServicePatientType::class,$personne);
        $form->add('send',SubmitType::class,['label'=>'modifier/ajouter le service pour ce patient']);
        $form->handleRequest($request);



        if(($form->isSubmitted() && $form->isValid())){
            //form
            $en->persist($personne);
            $en->flush();
            //message
            $this->addFlash('info','ajout réussi');

            return $this->redirectToRoute('list_patient');
        }

        return $this->render('dossier_patient/ServiceForm.html.twig',['form'=>$form->createView()]);
    }

    #[Route('/ajoutDiagno/{idper}', name: 'app_dossier_patient_ajout_diagno')]
    public function AjoutDiagno(PersonneRepository $per,$idper,Request $request,EntityManagerInterface $en): Response
    {
        $diagnostic = new Diagnostic();
        $form = $this->createForm(AjoutDiagnosticType::class,$diagnostic);
        $form->add('send',SubmitType::class,['label'=>'ajouter un diagnostic a se patient']);
        $form->handleRequest($request);

        if(($form->isSubmitted() && $form->isValid())){
            //form

            $medecin = $per->find($this->getUser());
            $medecin->addDiagnostiquer($diagnostic);
            $en->persist($medecin);

            $patient = $per->findOneById($idper);
            $patient->addDiagnostic($diagnostic);
            $en->persist($patient);

            $en->persist($diagnostic);
            $en->flush();
            //message
            $this->addFlash('info','ajout réussi');

            //diagnostic diagno
            //$per->AddPersoDiagno($idper,$diagnostic->getId());

            return $this->redirectToRoute('list_patient');
        }

        return $this->render('dossier_patient/DiagnoForm.html.twig',['form'=>$form->createView()]);
    }

    #[Route('/ajoutPrescri/{idper}', name: 'app_dossier_patient_ajout_prescri')]
    public function AjoutPrescription(PersonneRepository $per,$idper,Request $request,EntityManagerInterface $en): Response
    {
        $prescription = new Prescription();
        $form = $this->createForm(AjoutPrescriptionType::class,$prescription);
        $form->add('send',SubmitType::class,['label'=>'ajouter un prescription a se patient']);
        $form->handleRequest($request);


        if(($form->isSubmitted() && $form->isValid())){
            //form
            $appPres = new AppliquerPrescription();
            $appPres->setPatient($per->findOneById($idper))->setPrescription($prescription);
            $en->persist($appPres);
            $en->persist($prescription);
            $en->flush();


            //message
            $this->addFlash('info','ajout réussi');

            //prescription diagno
            //$per->AddPersoDiagno($idper,$prescription->getId());

            return $this->redirectToRoute('list_patient');
        }

        return $this->render('dossier_patient/PrescriptionForm.html.twig',['form'=>$form->createView()]);
    }

    #[Route('/appliquer/{idprescription}/{idpatient}', name: 'patient_appliquer')]
    public function appliquer($idprescription, $idpatient,PersonneRepository $pers,PrescriptionRepository $presciption ,AppliquerPrescriptionRepository $prescripApp, EntityManagerInterface $em): Response
    {
        $idApplication = $prescripApp->retrouverPrescription($idpatient,$idprescription);

        $ApplicationPrescription = $prescripApp->find($idApplication[0]->getId());
        $soignant = $pers->findOneById($this->getUser()->getId());
        $ApplicationPrescription->setSoignant($soignant)->setDateHeureApplication(new \DateTime());

        $em->persist($ApplicationPrescription);
        $em->flush();

        $patient = $pers->findOneById($idpatient);
        $presci = $presciption->findOneById($idprescription);

        $test = $patient->getPatient()->getId();

        $appPrescription = new AppliquerPrescription();
        $appPrescription->setPatient($patient)->setPrescription($presci);
        $em->persist($appPrescription);
        $em->flush();

        return $this->redirectToRoute('app_dossier_patient',['idpatient'=>$test]);
    }

    #[Route('/modifier/{idprescription}', name: 'patient_modifier')]
    public function modifier($idprescription,Request $request,PrescriptionRepository $pre, EntityManagerInterface $em): Response
    {
        $prescription = $pre->findOneById($idprescription);
        $form = $this->createForm(AjoutPrescriptionType::class,$prescription);
        $form->add('send',SubmitType::class,['label'=>'ajouter un prescription a se patient']);
        $form->handleRequest($request);


        if(($form->isSubmitted() && $form->isValid())){
            //form
            $em->persist($prescription);
            $em->flush();


            //message
            $this->addFlash('info','ajout réussi');

            //prescription diagno
            //$per->AddPersoDiagno($idper,$prescription->getId());

            return $this->redirectToRoute('list_patient');
        }

        return $this->render('dossier_patient/PrescriptionForm.html.twig',['form'=>$form->createView()]);
    }
}
