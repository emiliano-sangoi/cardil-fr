<?php

namespace App\Controller;

use App\Entity\Fournisseur;
use App\Form\FournisseurType;
use App\Repository\FournisseurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/fournisseurs')]
class FournisseursController extends AbstractController
{
    #[Route('/', name: 'app_fournisseurs_index', methods: ['GET'])]
    public function index(FournisseurRepository $fournisseurRepository): Response
    {
        return $this->render('fournisseurs/index.html.twig', [
            'fournisseurs' => $fournisseurRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_fournisseurs_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FournisseurRepository $fournisseurRepository): Response
    {
        $fournisseur = new Fournisseur();
        $form = $this->createForm(FournisseurType::class, $fournisseur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fournisseurRepository->add($fournisseur, true);

            return $this->redirectToRoute('app_fournisseurs_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('fournisseurs/new.html.twig', [
            'fournisseur' => $fournisseur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_fournisseurs_show', methods: ['GET'])]
    public function show(Fournisseur $fournisseur): Response
    {
        return $this->render('fournisseurs/show.html.twig', [
            'fournisseur' => $fournisseur,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_fournisseurs_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Fournisseur $fournisseur, FournisseurRepository $fournisseurRepository): Response
    {
        $form = $this->createForm(FournisseurType::class, $fournisseur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fournisseurRepository->add($fournisseur, true);

            return $this->redirectToRoute('app_fournisseurs_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('fournisseurs/edit.html.twig', [
            'fournisseur' => $fournisseur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_fournisseurs_delete', methods: ['POST'])]
    public function delete(Request $request, Fournisseur $fournisseur, FournisseurRepository $fournisseurRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$fournisseur->getId(), $request->request->get('_token'))) {
            $fournisseurRepository->remove($fournisseur, true);
        }

        return $this->redirectToRoute('app_fournisseurs_index', [], Response::HTTP_SEE_OTHER);
    }
}
