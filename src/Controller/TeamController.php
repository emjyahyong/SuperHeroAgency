<?php
// src/Controller/TeamController.php

namespace App\Controller;

use App\Entity\Team;
use App\Form\TeamType;
use App\Repository\TeamRepository;
use App\Repository\SuperHeroRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TeamController extends AbstractController
{
    #[Route('/team', name: 'app_team_index')]
    public function index(TeamRepository $teamRepository): Response
    {
        $teams = $teamRepository->findAll();

        return $this->render('team/index.html.twig', [
            'teams' => $teams,
        ]);
    }

    #[Route('/team/new', name: 'app_team_new')]
    public function new(Request $request, EntityManagerInterface $entityManager, SuperHeroRepository $superHeroRepository): Response
    {
        $team = new Team();
        $form = $this->createForm(TeamType::class, $team);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Validation des contraintes
            $leader = $team->getLeader();
            if ($leader && $leader->getEnergyLevel() <= 80) {
                $this->addFlash('error', 'Le leader doit avoir un niveau d\'énergie supérieur à 80.');
            } elseif (count($team->getMembers()) < 2 || count($team->getMembers()) > 5) {
                $this->addFlash('error', 'Une équipe doit avoir entre 2 et 5 membres.');
            } else {
                $team->setCreatedAt(new \DateTimeImmutable());
                $entityManager->persist($team);
                $entityManager->flush();

                return $this->redirectToRoute('app_team_index');
            }
        }

        return $this->render('team/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/team/{id}', name: 'app_team_show')]
    public function show(Team $team): Response
    {
        return $this->render('team/show.html.twig', [
            'team' => $team,
        ]);
    }

    #[Route('/team/{id}/edit', name: 'app_team_edit')]
    public function edit(Request $request, Team $team, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Validation des contraintes
            $leader = $team->getLeader();
            if ($leader && $leader->getEnergyLevel() <= 80) {
                $this->addFlash('error', 'Le leader doit avoir un niveau d\'énergie supérieur à 80.');
            } elseif (count($team->getMembers()) < 2 || count($team->getMembers()) > 5) {
                $this->addFlash('error', 'Une équipe doit avoir entre 2 et 5 membres.');
            } else {
                $entityManager->flush();

                return $this->redirectToRoute('app_team_index');
            }
        }

        return $this->render('team/edit.html.twig', [
            'form' => $form->createView(),
            'team' => $team,
        ]);
    }

    #[Route('/team/{id}/delete', name: 'app_team_delete', methods: ['POST'])]
    public function delete(Request $request, Team $team, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $team->getId(), $request->request->get('_token'))) {
            $entityManager->remove($team);
            $entityManager->flush();

            $this->addFlash('success', 'Équipe supprimée avec succès.');
        }

        return $this->redirectToRoute('app_team_index');
    }
}
