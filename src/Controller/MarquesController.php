<?php

namespace App\Controller;

use App\Entity\Marque;
use App\Form\MarqueType;
use App\Repository\MarqueRepository;
use App\Repository\ModelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/marques')]
class MarquesController extends AbstractController
{
    const SIDEBAR_ID = 2;

    #[Route('/', name: 'app_marques_index', methods: ['GET'])]
    public function index(MarqueRepository $marqueRepository, TranslatorInterface $translator): Response
    {
        return $this->render('marques/index.html.twig', [
            'marques' => $marqueRepository->findAll(),
            'page_title' => $translator->trans('Brands'),
            'active_section' => self::SIDEBAR_ID
        ]);
    }

    #[Route('/json', name: 'app_marques_index_json', methods: ['GET'])]
    public function indexJson(MarqueRepository $marqueRepository): Response
    {
        return new JsonResponse($marqueRepository->findAll());
    }

    #[Route('/{id}/models', name: 'app_models_by_marque_index', methods: ['GET'])]
    public function getModelsByMarque(Marque $marque, ModelRepository $modelRepository, TranslatorInterface $translator): Response
    {

        $titulo  = $marque->getNom() . ' - ' . $translator->trans('Models');

        return $this->render('models/index.html.twig', [
            'models' => $modelRepository->findBy(['marque' => $marque]),
            'marque' => $marque,
            'page_title' => $titulo,
            'active_section' => self::SIDEBAR_ID
        ]);
    }

    #[Route('/{id}/models/json', name: 'app_models_by_marque_index_json', methods: ['GET'])]
    public function getModelsByMarqueJson(Marque $marque, ModelRepository $modelRepository): Response
    {
        return new JsonResponse($modelRepository->findBy(['marque' => $marque]));
    }

    #[Route('/new', name: 'app_marques_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MarqueRepository $marqueRepository, TranslatorInterface $translator): Response
    {
        $marque = new Marque();
        $form = $this->createForm(MarqueType::class, $marque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $marqueRepository->add($marque, true);

            return $this->redirectToRoute('app_marques_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('marques/new.html.twig', [
            'marque' => $marque,
            'page_title' => $translator->trans('Brands'),
            'active_section' => self::SIDEBAR_ID,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_marques_show', methods: ['GET'])]
    public function show(Marque $marque, TranslatorInterface $translator): Response
    {
        $form = $this->createForm(MarqueType::class, $marque, [
            'disabled' => true
        ]);

        return $this->render('marques/show.html.twig', [
            'marque' => $marque,
            'page_title' => $translator->trans('Brands'),
            'active_section' => self::SIDEBAR_ID,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_marques_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Marque $marque, MarqueRepository $marqueRepository, TranslatorInterface $translator): Response
    {
        $form = $this->createForm(MarqueType::class, $marque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $marqueRepository->add($marque, true);

            return $this->redirectToRoute('app_marques_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('marques/edit.html.twig', [
            'marque' => $marque,
            'page_title' => $translator->trans('Brands'),
            'active_section' => self::SIDEBAR_ID,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_marques_delete', methods: ['POST'])]
    public function delete(Request $request, Marque $marque, MarqueRepository $marqueRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$marque->getId(), $request->request->get('_token'))) {
            $marqueRepository->remove($marque, true);
        }

        return $this->redirectToRoute('app_marques_index', [], Response::HTTP_SEE_OTHER);
    }
}
