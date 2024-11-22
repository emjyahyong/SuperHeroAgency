<?php

namespace App\Controller;

use App\Entity\Power;
use App\Form\PowerType;
use App\Repository\PowerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/power')]
class PowerController extends AbstractController
{
    #[Route('/', name: 'app_power_index', methods: ['GET'])]
    public function index(PowerRepository $powerRepository): Response
    {
        return $this->render('power/index.html.twig', [
            'powers' => $powerRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_power_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $power = new Power();
        $form = $this->createForm(PowerType::class, $power);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($power);
            $entityManager->flush();

            return $this->redirectToRoute('app_power_index');
        }

        return $this->render('power/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_power_show', methods: ['GET'])]
    public function show(Power $power): Response
    {
        return $this->render('power/show.html.twig', [
            'power' => $power,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_power_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Power $power, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PowerType::class, $power);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_power_index');
        }

        return $this->render('power/edit.html.twig', [
            'form' => $form->createView(),
            'power' => $power,
        ]);
    }

    #[Route('/{id}', name: 'app_power_delete', methods: ['POST'])]
    public function delete(Request $request, Power $power, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $power->getId(), $request->request->get('_token'))) {
            $entityManager->remove($power);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_power_index');
    }
}