<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LitController extends AbstractController
{
    /**
     * @Route("/lit", name="lit")
     */
    #[Route('/lit', name: 'app_lit')]
    public function index()
    {
        return $this->render('LitsTwig/view.html.twig');
    }
}