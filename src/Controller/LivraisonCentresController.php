<?php

namespace App\Controller;

use App\Entity\Fournisseur;
use App\Entity\LivraisonCentre;
use App\Form\LivraisonCentreType;
use App\Repository\LivraisonCentreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/fournisseurs/')]
class LivraisonCentresController extends AbstractController
{
    const SIDEBAR_ID = 8;

    #[Route('/{id}/livraison-centres', name: 'app_livraison_centres_index', methods: ['GET'])]
    public function index(Fournisseur $fournisseur, LivraisonCentreRepository $livraisonCentreRepository, TranslatorInterface $translator): Response
    {

        $titulo = $fournisseur->getNomCommercial() . ' - ' . $translator->trans('form.fournisseur.labels.distributionCenters');

        return $this->render('livraison_centres/index.html.twig', [
            'page_title' => $titulo,
            'active_section' => self::SIDEBAR_ID,
            'fournisseur' => $fournisseur,
            'centers' => json_encode($fournisseur->getLivraisonCenters()->toArray()),
        ]);
    }

    #[Route('/{id}/livraison-centres/json', name: 'app_livraison_centres_index_json', methods: ['GET'])]
    public function indexJson(Fournisseur $fournisseur, LivraisonCentreRepository $livraisonCentreRepository): Response
    {
        return new JsonResponse($livraisonCentreRepository->findBy([
            'fournisseur' => $fournisseur,
            'etat' => LivraisonCentre::ETAT_OUI
        ]));
    }

    #[Route('/{id}/livraison-centres/new', name: 'app_livraison_centres_new', methods: ['GET', 'POST'])]
    public function new(Fournisseur $fournisseur, Request $request, LivraisonCentreRepository $livraisonCentreRepository, TranslatorInterface $translator): Response
    {
        $livraisonCentre = new LivraisonCentre();
        $livraisonCentre->setFournisseur($fournisseur);
        $form = $this->createForm(LivraisonCentreType::class, $livraisonCentre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $livraisonCentreRepository->add($livraisonCentre, true);

            return $this->redirectToRoute('app_livraison_centres_index', [], Response::HTTP_SEE_OTHER);
        }

        $titulo = $translator->trans('Providers') . ' - ' . $translator->trans('Show');

        return $this->renderForm('livraison_centres/new.html.twig', [
            'livraison_centre' => $livraisonCentre,
            'page_title' => $titulo,
            'active_section' => self::SIDEBAR_ID,
            'fournisseur' => $fournisseur,
            'centers' => json_encode($fournisseur->getLivraisonCenters()->toArray()),
            'form' => $form,
        ]);
    }

    #[Route('/livraison-centres/{id}', name: 'app_livraison_centres_show', methods: ['GET'])]
    public function show(LivraisonCentre $livraisonCentre, TranslatorInterface $translator): Response
    {
        return $this->render('livraison_centres/show.html.twig', [
            'livraison_centre' => $livraisonCentre,
            'active_section' => self::SIDEBAR_ID,
        ]);
    }

    #[Route('/livraison-centres/{id}/edit', name: 'app_livraison_centres_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, LivraisonCentre $livraisonCentre, LivraisonCentreRepository $livraisonCentreRepository, TranslatorInterface $translator): Response
    {
        $form = $this->createForm(LivraisonCentreType::class, $livraisonCentre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $livraisonCentreRepository->add($livraisonCentre, true);

            return $this->redirectToRoute('app_livraison_centres_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('livraison_centres/edit.html.twig', [
            'livraison_centre' => $livraisonCentre,
            'form' => $form,
            'active_section' => self::SIDEBAR_ID,
        ]);
    }

    #[Route('/livraison-centres/{id}', name: 'app_livraison_centres_delete', methods: ['POST'])]
    public function delete(Request $request, LivraisonCentre $livraisonCentre, LivraisonCentreRepository $livraisonCentreRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$livraisonCentre->getId(), $request->request->get('_token'))) {
            $livraisonCentreRepository->remove($livraisonCentre, true);
        }

        return $this->redirectToRoute('app_livraison_centres_index', [], Response::HTTP_SEE_OTHER);
    }
}
