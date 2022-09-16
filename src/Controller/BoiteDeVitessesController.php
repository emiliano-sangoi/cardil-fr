<?php

namespace App\Controller;

use App\Entity\BoiteDeVitesse;
use App\Form\BoiteDeVitesseType;
use App\Repository\BoiteDeVitesseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/boite-de-vitesses')]
class BoiteDeVitessesController extends AbstractController
{

    const SIDEBAR_ID = 4;
    const TITLE_KEY = 'entity.boite_de_vitesses.title';

    #[Route('/', name: 'app_boite_de_vitesses_index', methods: ['GET'])]
    public function index(TranslatorInterface $translator): Response
    {
        return $this->render('boite_de_vitesses/index.html.twig', [
            'page_title' => $translator->trans(self::TITLE_KEY),
            'active_section' => self::SIDEBAR_ID
        ]);
    }

    #[Route('/json', name: 'app_boite_de_vitesses_index_json', methods: ['GET'])]
    public function indexJson(BoiteDeVitesseRepository $boiteDeVitesseRepository): Response
    {
        return new JsonResponse($boiteDeVitesseRepository->findAll());
    }

    #[Route('/new', name: 'app_boite_de_vitesses_new', methods: ['GET', 'POST'])]
    public function new(Request $request, BoiteDeVitesseRepository $boiteDeVitesseRepository, TranslatorInterface $translator): Response
    {
        $boiteDeVitesse = new BoiteDeVitesse();
        $form = $this->createForm(BoiteDeVitesseType::class, $boiteDeVitesse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $boiteDeVitesseRepository->add($boiteDeVitesse, true);

            return $this->redirectToRoute('app_boite_de_vitesses_index', [], Response::HTTP_SEE_OTHER);
        }

        $titulo = $translator->trans(self::TITLE_KEY) . ' - ' . $translator->trans('actions.add');

        return $this->renderForm('boite_de_vitesses/new.html.twig', [
            'boite_de_vitesse' => $boiteDeVitesse,
            'page_title' => $titulo,
            'active_section' => self::SIDEBAR_ID,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_boite_de_vitesses_show', methods: ['GET'])]
    public function show(BoiteDeVitesse $boiteDeVitesse, TranslatorInterface $translator): Response
    {
        $form = $this->createForm(BoiteDeVitesseType::class, $boiteDeVitesse, [
            'disabled' => true
        ]);

        $titulo = $translator->trans(self::TITLE_KEY) . ' - ' . $translator->trans('actions.show');

        return $this->render('boite_de_vitesses/show.html.twig', [
            'boite_de_vitesse' => $boiteDeVitesse,
            'page_title' => $titulo,
            'active_section' => self::SIDEBAR_ID,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_boite_de_vitesses_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, BoiteDeVitesse $boiteDeVitesse, BoiteDeVitesseRepository $boiteDeVitesseRepository, TranslatorInterface $translator): Response
    {
        $form = $this->createForm(BoiteDeVitesseType::class, $boiteDeVitesse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $boiteDeVitesseRepository->add($boiteDeVitesse, true);

            return $this->redirectToRoute('app_boite_de_vitesses_index', [], Response::HTTP_SEE_OTHER);
        }

        $titulo = $translator->trans(self::TITLE_KEY) . ' - ' . $translator->trans('actions.edit');

        return $this->renderForm('boite_de_vitesses/edit.html.twig', [
            'boite_de_vitesse' => $boiteDeVitesse,
            'page_title' => $titulo,
            'active_section' => self::SIDEBAR_ID,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_boite_de_vitesses_delete', methods: ['POST'])]
    public function delete(Request $request, BoiteDeVitesse $boiteDeVitesse, BoiteDeVitesseRepository $boiteDeVitesseRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$boiteDeVitesse->getId(), $request->request->get('_token'))) {
            $boiteDeVitesseRepository->remove($boiteDeVitesse, true);
        }

        return $this->redirectToRoute('app_boite_de_vitesses_index', [], Response::HTTP_SEE_OTHER);
    }
}
