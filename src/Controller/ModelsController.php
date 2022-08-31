<?php

namespace App\Controller;

use App\Entity\Marque;
use App\Entity\Model;
use App\Form\ModelType;
use App\Repository\ModelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;


class ModelsController extends AbstractController
{

    const SIDEBAR_ID = 2;

    #[Route('/models', name: 'app_models_index', methods: ['GET'])]
    public function index(ModelRepository $modelRepository, TranslatorInterface $translator): Response
    {
        return $this->render('models/index.html.twig', [
            'models' => $modelRepository->findAll(),
            'page_title' => $translator->trans('Models'),
            'active_section' => self::SIDEBAR_ID
        ]);
    }

    #[Route('/models/json', name: 'app_models_index_json', methods: ['GET'])]
    public function indexJson(ModelRepository $modelRepository): Response
    {
        return new JsonResponse($modelRepository->findAll());
    }

    #[Route('/marques/{id}/models/new', name: 'app_models_new', methods: ['GET', 'POST'])]
    public function new(Marque $marque, Request $request, ModelRepository $modelRepository, TranslatorInterface $translator): Response
    {
        $model = new Model();
        $model->setMarque($marque);
        $form = $this->createForm(ModelType::class, $model, [
            'translator' => $translator,
            'marque_selector_disabled' => true
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $modelRepository->add($model, true);

            return $this->redirectToRoute('app_models_by_marque_index', [ 'id' => $marque->getId() ], Response::HTTP_SEE_OTHER);
        }

        $titulo  = $marque->getNom() . ' - ' . $translator->trans('Add') . ' ' . mb_strtolower($translator->trans('Model'));

        return $this->renderForm('models/new.html.twig', [
            'model' => $model,
            'form' => $form,
            'page_title' => $titulo,
            'active_section' => self::SIDEBAR_ID
        ]);
    }

    #[Route('/marques/{id}/models', name: 'app_models_by_marque_index', methods: ['GET'])]
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

    #[Route('/marques/{id}/models/json', name: 'app_models_by_marque_index_json', methods: ['GET'])]
    public function getModelsByMarqueJson(Marque $marque, ModelRepository $modelRepository): Response
    {
        return new JsonResponse($modelRepository->findBy(['marque' => $marque]));
    }

    #[Route('/models/{id}', name: 'app_models_show', methods: ['GET'])]
    public function show(Model $model, TranslatorInterface $translator): Response
    {
        $form = $this->createForm(ModelType::class, $model, [
            'disabled' => true,
            'translator' => $translator
        ]);

        $titulo  = $model->getMarque()->getNom() . ' - ' . $model->getNom();

        return $this->render('models/show.html.twig', [
            'model' => $model,
            'page_title' => mb_strtoupper($titulo),
            'active_section' => self::SIDEBAR_ID,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/models/{id}/edit', name: 'app_models_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Model $model, ModelRepository $modelRepository, TranslatorInterface $translator): Response
    {
        $form = $this->createForm(ModelType::class, $model, [
            'translator' => $translator
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $modelRepository->add($model, true);

            return $this->redirectToRoute('app_models_by_marque_index', [ 'id' => $model->getMarque()->getId() ], Response::HTTP_SEE_OTHER);
        }

        $titulo  = $model->getMarque()->getNom() . ' - ' . $model->getNom();

        return $this->renderForm('models/edit.html.twig', [
            'model' => $model,
            'page_title' => mb_strtoupper($titulo),
            'active_section' => self::SIDEBAR_ID,
            'form' => $form,
        ]);
    }

    #[Route('/models/{id}', name: 'app_models_delete', methods: ['POST'])]
    public function delete(Request $request, Model $model, ModelRepository $modelRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$model->getId(), $request->request->get('_token'))) {
            $modelRepository->remove($model, true);
        }

        return $this->redirectToRoute('app_models_by_marque_index', [ 'id' => $model->getMarque()->getId() ], Response::HTTP_SEE_OTHER);
    }
}
