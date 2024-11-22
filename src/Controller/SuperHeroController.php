<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SuperHeroController extends AbstractController
{
    #[Route('/super/hero', name: 'app_super_hero')]
    public function index(): Response
    {
        return $this->render('super_hero/index.html.twig', [
            'controller_name' => 'SuperHeroController',
        ]);
    }
}
