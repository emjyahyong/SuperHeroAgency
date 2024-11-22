<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PowerController extends AbstractController
{
    #[Route('/power', name: 'app_power')]
    public function index(): Response
    {
        return $this->render('power/index.html.twig', [
            'controller_name' => 'PowerController',
        ]);
    }
}
