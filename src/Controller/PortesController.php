<?php

namespace App\Controller;

use App\Entity\Porte;
use App\Form\PorteType;
use App\Repository\PorteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/portes')]
class PortesController extends AbstractController
{
    const SIDEBAR_ID = 4;

    #[Route('/', name: 'app_portes_index', methods: ['GET'])]
    public function index(PorteRepository $porteRepository, TranslatorInterface $translator): Response
    {
        return $this->render('portes/index.html.twig', [
            'page_title' => $translator->trans('Doors'),
            'active_section' => self::SIDEBAR_ID
        ]);
    }

    #[Route('/json', name: 'app_portes_index_json', methods: ['GET'])]
    public function indexJson(PorteRepository $porteRepository, TranslatorInterface $translator): Response
    {
        return new JsonResponse($porteRepository->findAll());
    }

    #[Route('/new', name: 'app_portes_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PorteRepository $porteRepository, TranslatorInterface $translator): Response
    {
        $porte = new Porte();
        $form = $this->createForm(PorteType::class, $porte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $porteRepository->add($porte, true);

            return $this->redirectToRoute('app_portes_index', [], Response::HTTP_SEE_OTHER);
        }

        $titulo  = $translator->trans('Doors') . ' - ' . $translator->trans('Add');

        return $this->renderForm('portes/new.html.twig', [
            'porte' => $porte,
            'form' => $form,
            'active_section' => self::SIDEBAR_ID,
            'page_title' => $titulo
        ]);
    }

    #[Route('/{id}', name: 'app_portes_show', methods: ['GET'])]
    public function show(Porte $porte, TranslatorInterface $translator): Response
    {
        $form = $this->createForm(PorteType::class, $porte, [
            'disabled' => true,
            'translator' => $translator
        ]);

        $titulo  = $translator->trans('Doors') . ' - ' . $porte->getNom();

        return $this->render('portes/show.html.twig', [
            'porte' => $porte,
            'active_section' => self::SIDEBAR_ID,
            'page_title' => $titulo,
            'form' => $form->createView()
        ]);
    }

    #[Route('/{id}/edit', name: 'app_portes_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Porte $porte, PorteRepository $porteRepository, TranslatorInterface $translator): Response
    {
        $form = $this->createForm(PorteType::class, $porte, [
            'translator' => $translator
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $porteRepository->add($porte, true);

            return $this->redirectToRoute('app_portes_index', [], Response::HTTP_SEE_OTHER);
        }

        $titulo  = $translator->trans('Doors') . ' - ' . $porte->getNom();

        return $this->renderForm('portes/edit.html.twig', [
            'porte' => $porte,
            'active_section' => self::SIDEBAR_ID,
            'page_title' => $titulo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_portes_delete', methods: ['POST'])]
    public function delete(Request $request, Porte $porte, PorteRepository $porteRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$porte->getId(), $request->request->get('_token'))) {
            $porteRepository->remove($porte, true);
        }

        return $this->redirectToRoute('app_portes_index', [], Response::HTTP_SEE_OTHER);
    }
}
