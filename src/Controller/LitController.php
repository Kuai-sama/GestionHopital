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
    #[Route(
        '/lits/{page}',
        name: 'list_lits',
        requirements: ['page' => '\d+'],
        defaults: ['page' => 1]
    )]

    public function index($page, EntityManagerInterface $em)
    {

        $nbPerPage = 10;
        // On compte tout les articles qui sont publiés (méthode magique count() de Doctrine)

        $lits = $em->getRepository(Lit::class)->findAllWithSalleAndPaging($page, $nbPerPage);

        $nbTotalPages = intval(ceil(count($em->getRepository(Lit::class)->findAll()) / $nbPerPage));

        if ($page > $nbTotalPages)
            throw $this->createNotFoundException("La page $page n'existe pas");

        return $this->render('LitsTwig/view.html.twig', [
            'lits' => $lits,
            'nbTotalPages' => $nbTotalPages,
        ]);
    }
}
