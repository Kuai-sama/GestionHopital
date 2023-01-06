<?php

namespace App\Controller;

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
}
