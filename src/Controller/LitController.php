<?php

namespace App\Controller;

use App\Entity\Lit;
use App\Entity\Salle;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LitController extends AbstractController
{
    /**
     * @Route("/lit", name="lit")
     */
    #[Route('/lit', name: 'app_lit')]
    public function index(EntityManagerInterface $em)
    {
        $lits = $em->getRepository(Lit::class)->findAll();
        return $this->render('LitsTwig/view.html.twig', [
            'lits' => $lits,
        ]);
    }
}