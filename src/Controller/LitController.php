<?php

namespace App\Controller;

use App\Entity\Lit;
use App\Entity\Salle;
use App\Entity\Personne;
use App\Form\AjoutLitType;
use App\Form\ModifierLitType;
use App\Repository\PatientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/lits', name: 'lits_')]
class LitController extends AbstractController
{
    /**
     * @Route("/lit", name="lit")
     */
    #[Route(
        '/{page}',
        name: 'list',
        requirements: ['page' => '\d+'],
        defaults: ['page' => 1]
    )]

    public function index($page, EntityManagerInterface $em)
    {

        $nbPerPage = 25;
        // On compte tout les articles qui sont publiés (méthode magique count() de Doctrine)

        $lits = $em->getRepository(Lit::class)->findAllWithSalleAndPaging($page, $nbPerPage);

        $nbTotalPages = intval(ceil(count($em->getRepository(Lit::class)->findAll()) / $nbPerPage));

        if ($page > $nbTotalPages)
            throw $this->createNotFoundException("La page $page n'existe pas");

        return $this->render('Lits/view.html.twig', [
            'lits' => $lits,
            'nbTotalPages' => $nbTotalPages,
        ]);
    }

    #[Route('/emplacementPatient', name:'emplacementPatient')]
    public function ouEstLePatient(PatientRepository $patient){

        dump($patient->getPatLit());
        return $this->render('Lits/viewPat.html.twig', [
            'patient' => $patient->getPatLit()
        ]);
    }

    #[Route('/AjouterLit', name:'Ajouter')]
    public function AjouterLit(EntityManagerInterface $em, Request $request){

        $lit = new Lit();
        
        $form = $this->createForm(AjoutLitType::class, $lit);
        $form->add('send', SubmitType::class, ['label' => 'Valider']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lit->setLitOccupe(false);
            $em->persist($lit);
            $em->flush();

            return $this->redirectToRoute('lits_list');
        }

        return $this->render('form/ajouterlit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/ModifierLit/{id}', name:'Modifier', requirements: ['id' => '\d+'])]
    public function ModifierLit($id, EntityManagerInterface $em, Request $request){

        $lit = $em->getRepository(Lit::class)->findOneBy(['id'=>$id]);

        $form = $this->createForm(ModifierLitType::class, $lit);
        $form->add('send', SubmitType::class, ['label' => 'Valider']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $personne = $em->getRepository(Personne::class)->findOneBy(['id'=>$lit->getIdPersonne()]);
            $personne->setIdLit($lit);
            $lit->setLitOccupe(true);

            $em->persist($personne);            
            $em->persist($lit);
            $em->flush();

            return $this->redirectToRoute('lits_list');
        }

        return $this->render('form/modifierlit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/SupprimerLit/{id}', name:'Supprimer', requirements: ['id' => '\d+'])]
    public function SupprimerLit($id, EntityManagerInterface $em, Request $request){

        $lit = $em->getRepository(Lit::class)->findOneBy(['id'=>$id]);
        $personne = $em->getRepository(Personne::class)->findOneBy(['id'=>$lit->getIdPersonne()]);
        if($personne != null){
            $personne->setIdLit(null);
            $em->persist($personne); 
        }
        $lit->setLitOccupe(false);
        $lit->setIdPersonne(null);
        $em->persist($lit);
        $em->flush();

        return $this->redirectToRoute('lits_list');
    }


}