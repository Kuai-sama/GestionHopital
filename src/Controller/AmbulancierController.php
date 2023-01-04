<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AmbulancierController extends AbstractController
{
    #[Route('/ambulancier', name: 'app_ambulancier')]
    public function index(): Response
    {
        return $this->render('ambulancier/index.html.twig', [
            'controller_name' => 'AmbulancierController',
        ]);
    }
}
