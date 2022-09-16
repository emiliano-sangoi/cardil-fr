<?php

namespace App\Controller;

use App\Entity\Pays;
use App\Form\PaysType;
use App\Repository\PaysRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/pays')]
class PaysController extends AbstractController
{
    const SIDEBAR_ID = 9;
    const TITLE_KEY = 'entity.fournisseur.title';


    #[Route('/', name: 'app_pays_index', methods: ['GET'])]
    public function index(TranslatorInterface $translator): Response
    {
        return $this->render('pays/index.html.twig', [
            'page_title' => $translator->trans(self::TITLE_KEY),
            'active_section' => self::SIDEBAR_ID
        ]);
    }

    #[Route('/json', name: 'app_pays_index_json', methods: ['GET'])]
    public function indexJson(PaysRepository $paysRepository): Response
    {
        return new JsonResponse($paysRepository->findAll());
    }

    #[Route('/new', name: 'app_pays_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PaysRepository $paysRepository, TranslatorInterface $translator): Response
    {
        $pay = new Pays();
        $form = $this->createForm(PaysType::class, $pay);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $paysRepository->add($pay, true);

            return $this->redirectToRoute('app_pays_index', [], Response::HTTP_SEE_OTHER);
        }

        $titulo = $translator->trans(self::TITLE_KEY) . ' - ' . $translator->trans('actions.add');

        return $this->renderForm('pays/new.html.twig', [
            'pay' => $pay,
            'page_title' => $titulo,
            'active_section' => self::SIDEBAR_ID,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_pays_show', methods: ['GET'])]
    public function show(Pays $pay, TranslatorInterface $translator): Response
    {
        $form = $this->createForm(PaysType::class, $pay, [
            'disabled' => true
        ]);

        $titulo = $translator->trans(self::TITLE_KEY) . ' - ' . $translator->trans('Show');

        return $this->render('pays/show.html.twig', [
            'pay' => $pay,
            'page_title' => $titulo,
            'active_section' => self::SIDEBAR_ID,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_pays_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Pays $pay, PaysRepository $paysRepository, TranslatorInterface $translator): Response
    {
        $form = $this->createForm(PaysType::class, $pay);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $paysRepository->add($pay, true);

            return $this->redirectToRoute('app_pays_index', [], Response::HTTP_SEE_OTHER);
        }

        $titulo = $translator->trans(self::TITLE_KEY) . ' - ' . $translator->trans('Edit');

        return $this->renderForm('pays/edit.html.twig', [
            'pay' => $pay,
            'active_section' => self::SIDEBAR_ID,
            'form' => $form,
            'page_title' => $titulo,
        ]);
    }

    #[Route('/{id}', name: 'app_pays_delete', methods: ['POST'])]
    public function delete(Request $request, Pays $pay, PaysRepository $paysRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pay->getId(), $request->request->get('_token'))) {
            $paysRepository->remove($pay, true);
        }

        return $this->redirectToRoute('app_pays_index', [], Response::HTTP_SEE_OTHER);
    }
}
