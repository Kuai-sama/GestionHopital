<?php

namespace App\Controller;

use App\Entity\Lit;
use App\Entity\Patient;
use App\Form\PatientType;
use App\Repository\LitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/patient', name: 'patient_')]
class PatientController extends AbstractController
{
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

        return $this->render('patient/venue.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('', name: 'menu')]
    public function menuAction(): Response
    {
        return new Response('Bonjour');
    }

    #[Route('/venue', name: 'venue')]
    public function FormVenueAction(EntityManagerInterface $em): Response
    {
        $disponible = $em->getRepository(Lit::class)->findBy(['LitOccupe' => false]);
        dump($disponible);
        if($disponible ==null)
        {
            return new Response('Aucun lit disponible');
        }

        $salle = $disponible->findSalle();
        dump($salle);
        return new Response ('Lit disponible salle '.$salle);
    }
}
