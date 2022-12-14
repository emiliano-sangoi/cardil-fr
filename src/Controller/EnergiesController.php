<?php

namespace App\Controller;

use App\Entity\Energie;
use App\Form\EnergieType;
use App\Repository\EnergieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/energies')]
class EnergiesController extends AbstractController
{
    const SIDEBAR_ID = 4;

    #[Route('/', name: 'app_energies_index', methods: ['GET'])]
    public function index(TranslatorInterface $translator): Response
    {
        return $this->render('energies/index.html.twig', [
            'page_title' => $translator->trans('Energy'),
            'active_section' => self::SIDEBAR_ID
        ]);
    }

    #[Route('/json', name: 'app_energies_index_json', methods: ['GET'])]
    public function indexJson(EnergieRepository $energieRepository): Response
    {
        return new JsonResponse($energieRepository->findAll());
    }

    #[Route('/new', name: 'app_energies_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EnergieRepository $energieRepository, TranslatorInterface $translator): Response
    {
        $energie = new Energie();
        $form = $this->createForm(EnergieType::class, $energie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $energieRepository->add($energie, true);

            return $this->redirectToRoute('app_energies_index', [], Response::HTTP_SEE_OTHER);
        }

        $titulo = $translator->trans('Energy') . ' - ' . $translator->trans('Add');

        return $this->renderForm('energies/new.html.twig', [
            'energie' => $energie,
            'form' => $form,
            'active_section' => self::SIDEBAR_ID,
            'page_title' => $titulo,
        ]);
    }

    #[Route('/{id}', name: 'app_energies_show', methods: ['GET'])]
    public function show(Energie $energie, TranslatorInterface $translator): Response
    {
        $form = $this->createForm(EnergieType::class, $energie, [
            'disabled' => true
        ]);

        $titulo = $translator->trans('Energy') . ' - ' . $translator->trans('Add');

        return $this->render('energies/show.html.twig', [
            'energie' => $energie,
            'page_title' => $titulo,
            'active_section' => self::SIDEBAR_ID,
            'form' => $form->createView()
        ]);
    }

    #[Route('/{id}/edit', name: 'app_energies_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Energie $energie, EnergieRepository $energieRepository, TranslatorInterface $translator): Response
    {
        $form = $this->createForm(EnergieType::class, $energie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $energieRepository->add($energie, true);

            return $this->redirectToRoute('app_energies_index', [], Response::HTTP_SEE_OTHER);
        }

        $titulo = $translator->trans('Energy') . ' - ' . $translator->trans('Edit');

        return $this->renderForm('energies/edit.html.twig', [
            'energie' => $energie,
            'page_title' => $titulo,
            'active_section' => self::SIDEBAR_ID,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_energies_delete', methods: ['POST'])]
    public function delete(Request $request, Energie $energie, EnergieRepository $energieRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$energie->getId(), $request->request->get('_token'))) {
            $energieRepository->remove($energie, true);
        }

        return $this->redirectToRoute('app_energies_index', [], Response::HTTP_SEE_OTHER);
    }
}
