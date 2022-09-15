<?php

namespace App\Controller;

use App\Entity\BoiteDeVitesse;
use App\Form\BoiteDeVitesseType;
use App\Repository\BoiteDeVitesseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/boite/de/vitesses')]
class BoiteDeVitessesController extends AbstractController
{
    #[Route('/', name: 'app_boite_de_vitesses_index', methods: ['GET'])]
    public function index(BoiteDeVitesseRepository $boiteDeVitesseRepository): Response
    {
        return $this->render('boite_de_vitesses/index.html.twig', [
            'boite_de_vitesses' => $boiteDeVitesseRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_boite_de_vitesses_new', methods: ['GET', 'POST'])]
    public function new(Request $request, BoiteDeVitesseRepository $boiteDeVitesseRepository): Response
    {
        $boiteDeVitesse = new BoiteDeVitesse();
        $form = $this->createForm(BoiteDeVitesseType::class, $boiteDeVitesse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $boiteDeVitesseRepository->add($boiteDeVitesse, true);

            return $this->redirectToRoute('app_boite_de_vitesses_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('boite_de_vitesses/new.html.twig', [
            'boite_de_vitesse' => $boiteDeVitesse,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_boite_de_vitesses_show', methods: ['GET'])]
    public function show(BoiteDeVitesse $boiteDeVitesse): Response
    {
        return $this->render('boite_de_vitesses/show.html.twig', [
            'boite_de_vitesse' => $boiteDeVitesse,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_boite_de_vitesses_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, BoiteDeVitesse $boiteDeVitesse, BoiteDeVitesseRepository $boiteDeVitesseRepository): Response
    {
        $form = $this->createForm(BoiteDeVitesseType::class, $boiteDeVitesse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $boiteDeVitesseRepository->add($boiteDeVitesse, true);

            return $this->redirectToRoute('app_boite_de_vitesses_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('boite_de_vitesses/edit.html.twig', [
            'boite_de_vitesse' => $boiteDeVitesse,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_boite_de_vitesses_delete', methods: ['POST'])]
    public function delete(Request $request, BoiteDeVitesse $boiteDeVitesse, BoiteDeVitesseRepository $boiteDeVitesseRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$boiteDeVitesse->getId(), $request->request->get('_token'))) {
            $boiteDeVitesseRepository->remove($boiteDeVitesse, true);
        }

        return $this->redirectToRoute('app_boite_de_vitesses_index', [], Response::HTTP_SEE_OTHER);
    }
}
