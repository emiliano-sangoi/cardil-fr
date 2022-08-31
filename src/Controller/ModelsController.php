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

#[Route('/models')]
class ModelsController extends AbstractController
{

    const SIDEBAR_ID = 2;

    #[Route('/', name: 'app_models_index', methods: ['GET'])]
    public function index(ModelRepository $modelRepository, TranslatorInterface $translator): Response
    {
        return $this->render('models/index.html.twig', [
            'models' => $modelRepository->findAll(),
            'page_title' => $translator->trans('Models'),
            'active_section' => self::SIDEBAR_ID
        ]);
    }

    #[Route('/', name: 'app_models_index_json', methods: ['GET'])]
    public function indexJson(ModelRepository $modelRepository): Response
    {
        return new JsonResponse($modelRepository->findAll());
    }

    #[Route('/new', name: 'app_models_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ModelRepository $modelRepository): Response
    {
        $model = new Model();
        $form = $this->createForm(ModelType::class, $model);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $modelRepository->add($model, true);

            return $this->redirectToRoute('app_models_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('models/new.html.twig', [
            'model' => $model,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_models_show', methods: ['GET'])]
    public function show(Model $model): Response
    {
        return $this->render('models/show.html.twig', [
            'model' => $model,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_models_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Model $model, ModelRepository $modelRepository): Response
    {
        $form = $this->createForm(ModelType::class, $model);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $modelRepository->add($model, true);

            return $this->redirectToRoute('app_models_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('models/edit.html.twig', [
            'model' => $model,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_models_delete', methods: ['POST'])]
    public function delete(Request $request, Model $model, ModelRepository $modelRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$model->getId(), $request->request->get('_token'))) {
            $modelRepository->remove($model, true);
        }

        return $this->redirectToRoute('app_models_index', [], Response::HTTP_SEE_OTHER);
    }
}
