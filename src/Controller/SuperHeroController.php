<?php

namespace App\Controller;

use App\Entity\SuperHero;
use App\Form\SuperHeroType;
use App\Repository\PowerRepository;
use App\Repository\SuperHeroRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/super/hero')]
class SuperHeroController extends AbstractController
{
    #[Route('/', name: 'app_super_hero_index', methods: ['GET'])]
    public function index(SuperHeroRepository $superHeroRepository, PowerRepository $powerRepository, Request $request)
{
    // Récupérer les filtres
    $available = $request->query->get('available');
    $power = $request->query->get('power');

    $queryBuilder = $superHeroRepository->createQueryBuilder('s');

    if ($available !== null && $available !== '') {
        $queryBuilder->andWhere('s.available = :available')
                     ->setParameter('available', $available);
    }

    if ($power !== null && $power !== '') {
        $queryBuilder->join('s.powers', 'p')
                     ->andWhere('p.name = :power')
                     ->setParameter('power', $power);
    }

    $superHeros = $queryBuilder->getQuery()->getResult();
    $powers = $powerRepository->findAll(); // Récupérer tous les pouvoirs disponibles

    return $this->render('super_hero/index.html.twig', [
        'super_heros' => $superHeros,
        'powers' => $powers, // Passer les pouvoirs au template
    ]);
}

    #[Route('/new', name: 'app_super_hero_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $superHero = new SuperHero();
        $form = $this->createForm(SuperHeroType::class, $superHero);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $superHero->setCreatedAt(new \DateTimeImmutable()); // On définit la date de création
            $entityManager->persist($superHero);
            $entityManager->flush();

            return $this->redirectToRoute('app_super_hero_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('super_hero/new.html.twig', [
            'super_hero' => $superHero,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_super_hero_show', methods: ['GET'])]
    public function show(SuperHero $superHero): Response
    {
        return $this->render('super_hero/show.html.twig', [
            'super_hero' => $superHero,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_super_hero_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SuperHero $superHero, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SuperHeroType::class, $superHero);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_super_hero_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('super_hero/edit.html.twig', [
            'super_hero' => $superHero,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_super_hero_delete', methods: ['POST'])]
    public function delete(Request $request, SuperHero $superHero, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$superHero->getId(), $request->request->get('_token'))) {
            $entityManager->remove($superHero);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_super_hero_index', [], Response::HTTP_SEE_OTHER);
    }
}
