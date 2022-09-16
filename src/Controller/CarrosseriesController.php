<?php

namespace App\Controller;

use App\Entity\Carrosserie;
use App\Form\CarrosserieType;
use App\Repository\CarrosserieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/carrosseries')]
class CarrosseriesController extends AbstractController
{
    #[Route('/', name: 'app_carrosseries_index', methods: ['GET'])]
    public function index(CarrosserieRepository $carrosserieRepository): Response
    {
        return $this->render('carrosseries/index.html.twig', [
            'carrosseries' => $carrosserieRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_carrosseries_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CarrosserieRepository $carrosserieRepository): Response
    {
        $carrosserie = new Carrosserie();
        $form = $this->createForm(CarrosserieType::class, $carrosserie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $carrosserieRepository->add($carrosserie, true);

            return $this->redirectToRoute('app_carrosseries_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('carrosseries/new.html.twig', [
            'carrosserie' => $carrosserie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_carrosseries_show', methods: ['GET'])]
    public function show(Carrosserie $carrosserie): Response
    {
        return $this->render('carrosseries/show.html.twig', [
            'carrosserie' => $carrosserie,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_carrosseries_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Carrosserie $carrosserie, CarrosserieRepository $carrosserieRepository): Response
    {
        $form = $this->createForm(CarrosserieType::class, $carrosserie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $carrosserieRepository->add($carrosserie, true);

            return $this->redirectToRoute('app_carrosseries_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('carrosseries/edit.html.twig', [
            'carrosserie' => $carrosserie,
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
