<?php

namespace App\Controller;

use App\Entity\Carrosserie;
use App\Form\CarrosserieType;
use App\Repository\CarrosserieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/carrosseries')]
class CarrosseriesController extends AbstractController
{
    const SIDEBAR_ID = 4;
    const TITLE_KEY = 'entity.carroseries.title';

    #[Route('/', name: 'app_carrosseries_index', methods: ['GET'])]
    public function index(TranslatorInterface $translator): Response
    {
        return $this->render('carrosseries/index.html.twig', [
            'page_title' => $translator->trans(self::TITLE_KEY),
            'active_section' => self::SIDEBAR_ID
        ]);
    }

    #[Route('/json', name: 'app_carrosseries_index_json', methods: ['GET'])]
    public function indexJson(CarrosserieRepository $carrosserieRepository, TranslatorInterface $translator): Response
    {
        return new JsonResponse($carrosserieRepository->findAll());
    }

    #[Route('/new', name: 'app_carrosseries_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CarrosserieRepository $carrosserieRepository, TranslatorInterface $translator): Response
    {
        $carrosserie = new Carrosserie();
        $form = $this->createForm(CarrosserieType::class, $carrosserie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $carrosserieRepository->add($carrosserie, true);

            return $this->redirectToRoute('app_carrosseries_index', [], Response::HTTP_SEE_OTHER);
        }

        $titulo = $translator->trans(self::TITLE_KEY) . ' - ' . $translator->trans('actions.add');

        return $this->renderForm('carrosseries/new.html.twig', [
            'carrosserie' => $carrosserie,
            'page_title' => $titulo,
            'active_section' => self::SIDEBAR_ID,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_carrosseries_show', methods: ['GET'])]
    public function show(Carrosserie $carrosserie, TranslatorInterface $translator): Response
    {
        $form = $this->createForm(CarrosserieType::class, $carrosserie, [
            'disabled' => true
        ]);

        $titulo = $translator->trans(self::TITLE_KEY) . ' - ' . $translator->trans('actions.show');

        return $this->render('carrosseries/show.html.twig', [
            'carrosserie' => $carrosserie,
            'page_title' => $titulo,
            'active_section' => self::SIDEBAR_ID,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_carrosseries_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Carrosserie $carrosserie, CarrosserieRepository $carrosserieRepository, TranslatorInterface $translator): Response
    {
        $form = $this->createForm(CarrosserieType::class, $carrosserie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $carrosserieRepository->add($carrosserie, true);

            return $this->redirectToRoute('app_carrosseries_index', [], Response::HTTP_SEE_OTHER);
        }

        $titulo = $translator->trans(self::TITLE_KEY) . ' - ' . $translator->trans('actions.edit');

        return $this->renderForm('carrosseries/edit.html.twig', [
            'carrosserie' => $carrosserie,
            'page_title' => $titulo,
            'active_section' => self::SIDEBAR_ID,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_carrosseries_delete', methods: ['POST'])]
    public function delete(Request $request, Carrosserie $carrosserie, CarrosserieRepository $carrosserieRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$carrosserie->getId(), $request->request->get('_token'))) {
            $carrosserieRepository->remove($carrosserie, true);
        }

        return $this->redirectToRoute('app_carrosseries_index', [], Response::HTTP_SEE_OTHER);
    }
}
