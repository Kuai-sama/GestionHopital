<?php

namespace App\Controller;

use App\Entity\Lit;
use App\Entity\Patient;
use App\Entity\Personne;
use App\Entity\RDV;
use App\Form\PrendreRDV;
use App\Repository\LitRepository;
use App\Repository\PatientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


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
    public function VenueAction(EntityManagerInterface $em, LitRepository $lit): Response
    {
        $user = $this->security->getUser();
        $idpersonne = $em->getRepository(Personne::class)->findOneBy(['Email' => $user->getUserIdentifier()]);
        $idpatient = $em->getRepository(Patient::class)->findOneBy(['Personne' => $idpersonne->getId()]);

        if($idpatient != "")
        {
            
            $test_present = $lit->findOneBy(['IdPersonne' => $idpersonne]);
            $code = $idpatient->getCodeEntre();
            if($test_present != "")
            {
                return $this->render('patient/venue.html.twig', ['salle' => "present", 'code' => null]);
            }
        }

        

        if($code != "")
        {
            $sallerecup = $lit->findOneBy(['IdPersonne' => $idpersonne->getId()]);
            $salle = $lit->findSalleAssos($sallerecup->getId());
            return $this->render('patient/venue.html.twig', ['salle' => $salle, 'code' => $code]);
        }

        if( $idpatient != "" && $code == "")
        {
            $disponible = $em->getRepository(Lit::class)->findOneBy(['LitOccupe' => false]);
            if (!$disponible) {
                return $this->render('patient/venue.html.twig', ['salle' => null, 'code' => ""]);
            }
            $sallerecup = $lit->findOneBy(['id' => $disponible->getId()]);
            $salle = $lit->findSalleAssos($sallerecup->getId());

            $disponible->setLitOccupe(true);
            $em->persist($disponible);

            $code = uniqid(10);
            $idpatient->setCodeEntre($code);
            $idpatient->setPersonne($idpersonne);
            $idpersonne->setLit($disponible);
            $em->persist($idpatient);
            $em->persist($idpersonne);
            $em->flush();
            return $this->render('patient/venue.html.twig', ['salle' => $salle, 'code' => $code]);
        }
        else  {
            $idpatient = new Patient();
            // verification de lit disponible
            $disponible = $em->getRepository(Lit::class)->findOneBy(['LitOccupe' => false]);
            if (!$disponible) {
                return $this->render('patient/venue.html.twig', ['salle' => null, 'code' => ""]);
            }
            $sallerecup = $lit->findOneBy(['id' => $disponible->getId()]);
            $salle = $lit->findSalleAssos($sallerecup->getId());

            $disponible->setLitOccupe(true);
            $em->persist($disponible);

            $code = uniqid(10);
            $idpatient->setCodeEntre($code);
            $idpatient->setPersonne($idpersonne);
            $idpersonne->setLit($disponible);
            $em->persist($idpatient);
            $em->persist($idpersonne);
            $em->flush();
            return $this->render('patient/venue.html.twig', ['salle' => $salle, 'code' => $idpatient->getCodeEntre()]);
        }
    }


    #[Route('/validation', name: 'validation')]
    public function validation(): Response
    {
        return $this->render('patient/validationDelete.html.twig');
    }

    #[Route('/listePatient', name: "list_patient")]
    public function listePat(PatientRepository $patient): Response
    {
        return $this->render('patient/listPat.html.twig', [
            'patients' => $patient->getPatPer(),
        ]);
    }

    #[Route('/prendreRDV', name: 'prendre_rdv')]
    public function prendreRDV(EntityManagerInterface $em, Request $request): Response
    {
        // form pour prendre un rdv
        $form = $this->createForm(PrendreRDV::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //Ajout dans la base de donnée
            $this->addFlash('info', 'Ajout réussi !');


            // On Créer un objet RDV
            $obj_rdv = new RDV();
            // On hydrate l'objet RDV
            $obj_rdv->setDateHeure($form->get('date_heure')->getData());
            $obj_rdv->setDescription($form->get('description')->getData());
            $obj_rdv->setPersonne1($this->getUser());

            // On récupère la liste des médecins
            $medecins = $em->getRepository(Personne::class)->findAllUser('["ROLE_MEDECIN"]');

            // On récupère la liste des rendez-vous
            $rdvs = $em->getRepository(RDV::class)->findALL();

            // On exclus les médecins qui ont déjà un rendez-vous à la date demandée
            foreach ($rdvs as $rdv) {
                foreach ($medecins as $key => $medecin) {

                    if ($rdv->getDuree() != null) {
                        $duree_rdv = $rdv->getDuree();

                        // On calcule la date de fin du rendez-vous (date_heure + durée du rendez-vous (en minutes))
                        $date_fin_rdv = clone $rdv->getDateHeure();
                        $date_fin_rdv->add(new \DateInterval('PT' . $duree_rdv . 'M'));

                        // Si rendez-vous est compris entre la date demandée et la date demandée + sa durée
                        if ($rdv->getDateHeure() >= $obj_rdv->getDateHeure() && $rdv->getDateHeure() <= $date_fin_rdv) {
                            // On supprime le médecin de la liste
                            unset($medecin[$key]);
                        }
                    }
                }
            }


            if (empty($medecins)) {
                $this->addFlash('info', 'Aucun médecin disponible à cette date');
                return $this->redirectToRoute('patient_rdv');
            }

            // On hydrate l'objet RDV avec le premier médecin de la liste
            $rdv->setPersonne2($medecins[0]);

            // On enregistre l'objet RDV en base de donnée
            $em->persist($rdv);

            // On enregistre les modifications en base de donnée
            $em->flush();

            // On redirige vers la page de confirmation
            $this->addFlash('info', 'Votre rendez-vous a bien été pris');
            return $this->redirectToRoute('patient_menu');
        }


        return $this->render('patient/rdv.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}