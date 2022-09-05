<?php

namespace App\Controller;

use App\Entity\Fournisseur;
use App\Form\FournisseurType;
use App\Repository\FournisseurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/fournisseurs')]
class FournisseursController extends AbstractController
{
    const SIDEBAR_ID = 2;

    #[Route('/', name: 'app_fournisseurs_index', methods: ['GET'])]
    public function index(TranslatorInterface $translator): Response
    {
        return $this->render('fournisseurs/index.html.twig', [
            'page_title' => $translator->trans('Providers'),
            'active_section' => self::SIDEBAR_ID
        ]);
    }

    #[Route('/json', name: 'app_fournisseurs_index_json', methods: ['GET'])]
    public function indexJson(FournisseurRepository $fournisseurRepository): Response
    {
        return new JsonResponse($fournisseurRepository->findAll());
    }

    #[Route('/new', name: 'app_fournisseurs_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FournisseurRepository $fournisseurRepository, TranslatorInterface $translator): Response
    {
        $fournisseur = new Fournisseur();
        $form = $this->createForm(FournisseurType::class, $fournisseur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fournisseurRepository->add($fournisseur, true);

            return $this->redirectToRoute('app_fournisseurs_index', [], Response::HTTP_SEE_OTHER);
        }

        $titulo = $translator->trans('Providers') . ' - ' . $translator->trans('Add');

        return $this->renderForm('fournisseurs/new.html.twig', [
            'page_title' => $titulo,
            'fournisseur' => $fournisseur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_fournisseurs_show', methods: ['GET'])]
    public function show(Fournisseur $fournisseur, TranslatorInterface $translator): Response
    {
        $form = $this->createForm(FournisseurType::class, $fournisseur, [
            'disabled' => true
        ]);

        $titulo = $translator->trans('Providers') . ' - ' . $translator->trans('Show');

        return $this->render('fournisseurs/show.html.twig', [
            'fournisseur' => $fournisseur,
            'page_title' => $titulo,
            'active_section' => self::SIDEBAR_ID,
            'centers' => json_encode($fournisseur->getLivraisonCenters()->toArray()),
            'form' => $form->createView()
        ]);
    }

    #[Route('/{id}/edit', name: 'app_fournisseurs_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Fournisseur $fournisseur, FournisseurRepository $fournisseurRepository, TranslatorInterface $translator): Response
    {
        $form = $this->createForm(FournisseurType::class, $fournisseur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fournisseurRepository->add($fournisseur, true);

            return $this->redirectToRoute('app_fournisseurs_index', [], Response::HTTP_SEE_OTHER);
        }

        $titulo = $translator->trans('Providers') . ' - ' . $translator->trans('Edit');

        return $this->renderForm('fournisseurs/edit.html.twig', [
            'fournisseur' => $fournisseur,
            'page_title' => $titulo,
            'active_section' => self::SIDEBAR_ID,
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
