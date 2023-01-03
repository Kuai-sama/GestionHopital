<?php

namespace App\Controller;

use App\Entity\Lit;
use App\Entity\Salle;
use App\Entity\Patient;
use App\Entity\Personne;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Security;


#[Route('/patient', name: 'patient_')]
class PatientController extends AbstractController
{
    /*
    #[Route('/FormPatient', name: 'formPatient')]
    public function FormPatientAction(Request $request, EntityManagerInterface $em): Response
    {
        $patient = new Patient();
        $form = $this->createForm(PatientType::class, $patient);
        $form->add('Envoyer', SubmitType::class, ['label' => 'Prendre Rendez-vous']);

        $form->handleRequest($request); 
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($patient);
            $em->flush();

            //succès
            $this->addFlash('info', 'Ajout réussit');

            return $this->redirectToRoute('patient_menu');
        }

        return $this->render('patient/rdv.html.twig', [
            'form' => $form->createView(),
        ]);
    }*/

    /**
     * @var Security
     */
    private $security;
    private $user;

    public function __construct(Security $security)
    {
        $this->security = $security;
        
    }


    #[Route('', name: 'menu')]
    public function menuAction(): Response
    {
        return $this->render('base.html.twig');
    }

    #[Route('/venue', name: 'venue')]
    public function VenueAction(EntityManagerInterface $em, Request $request): Response
    {  
        $user = $this->security->getUser();
        $idpersonne = $em->getRepository(Personne::class)->findOneBy(['Email'=>$user->getUserIdentifier()]);
        $idpatient = $em->getRepository(Patient::class)->findOneBy(['Personne'=>$idpersonne->getId()]);
        dump($idpatient->getCodeEntre() == "");
        if($idpatient->getCodeEntre() == "")
        {
            // verification de lit disponible
            $disponible = $em->getRepository(Lit::class)->findOneBy(['LitOccupe' => false]);
            if(!$disponible)
            {
                return $this->render('patient/venue.html.twig',['salle'=>null]);
            }
            $salle = $em->getRepository(Salle::class)->findOneBy(['id' => $disponible->getSalle()->getId()]); 
            $disponible->setLitOccupe(true);
            $em->persist($disponible);
            $em->flush();

            dump($code = random_bytes(10));
            $idpatient->setCodeEntre($code);
            $em->persist($idpatient);
            $em->flush();
            return $this->render('patient/venue.html.twig',['salle'=>$salle, 'code' =>$idpatient->getCodeEntre()]);
        }
        else
        {
            return $this->render('patient/venue.html.twig',['salle'=>null, 'code' =>$idpatient->getCodeEntre()]); // recup la salle TODO
        }
    }

    
    #[Route('/validation', name: 'validation')]
    public function validation(): Response
    {
        return $this->render('patient/validationDelete.html.twig');
    }
}
