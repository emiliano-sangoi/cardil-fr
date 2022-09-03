<?php

namespace App\Controller;

use App\Entity\BonusMalus;
use App\Form\BonusMalusType;
use App\Repository\BonusMalusRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/bonus/malus')]
class BonusMalusController extends AbstractController
{
    const SIDEBAR_ID = 10;

    #[Route('/', name: 'app_bonus_malus_index', methods: ['GET'])]
    public function index(BonusMalusRepository $bonusMalusRepository, TranslatorInterface $translator): Response
    {
        return $this->render('bonus_malus/index.html.twig', [
            'page_title' => $translator->trans('Bonus/Malus'),
            'active_section' => self::SIDEBAR_ID
        ]);
    }

    #[Route('/json', name: 'app_bonus_malus_index_json', methods: ['GET'])]
    public function indexJson(BonusMalusRepository $bonusMalusRepository, TranslatorInterface $translator): Response
    {
        $records = $bonusMalusRepository->findBy([], ['montant' => 'ASC']);
        return new JsonResponse($records);
    }

    #[Route('/bonus/json', name: 'app_bonus_index_json', methods: ['GET'])]
    public function bonusIndexJson(BonusMalusRepository $bonusMalusRepository, TranslatorInterface $translator): Response
    {
        $bonus = $bonusMalusRepository->findByMontantGreatherOrEqualThan();
        return new JsonResponse($bonus);
    }

    #[Route('/malus/json', name: 'app_malus_index_json', methods: ['GET'])]
    public function malusIndexJson(BonusMalusRepository $bonusMalusRepository, TranslatorInterface $translator): Response
    {
        $malus = $bonusMalusRepository->findByMontantLessOrEqualThan();
        return new JsonResponse($malus);
    }

    #[Route('/new', name: 'app_bonus_malus_new', methods: ['GET', 'POST'])]
    public function new(Request $request, BonusMalusRepository $bonusMalusRepository, TranslatorInterface $translator): Response
    {
        $bonusMalu = new BonusMalus();
        $form = $this->createForm(BonusMalusType::class, $bonusMalu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bonusMalusRepository->add($bonusMalu, true);

            return $this->redirectToRoute('app_bonus_malus_index', [], Response::HTTP_SEE_OTHER);
        }

        $titulo  = $translator->trans('Bonus/Malus') . ' - ' . $translator->trans('Add');

        return $this->renderForm('bonus_malus/new.html.twig', [
            'bonus_malu' => $bonusMalu,
            'page_title' => $titulo,
            'active_section' => self::SIDEBAR_ID,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_bonus_malus_show', methods: ['GET'])]
    public function show(BonusMalus $bonusMalu, TranslatorInterface $translator): Response
    {
        $form = $this->createForm(BonusMalusType::class, $bonusMalu, [
            'disabled' => true,
            'translator' => $translator
        ]);

        $titulo  = $translator->trans('Bonus/Malus') . ' - ' . $translator->trans('Show');

        return $this->render('bonus_malus/show.html.twig', [
            'bonus_malu' => $bonusMalu,
            'page_title' => $titulo,
            'active_section' => self::SIDEBAR_ID,
            'form' => $form->createView()
        ]);
    }

    #[Route('/{id}/edit', name: 'app_bonus_malus_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, BonusMalus $bonusMalu, BonusMalusRepository $bonusMalusRepository, TranslatorInterface $translator): Response
    {
        $form = $this->createForm(BonusMalusType::class, $bonusMalu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bonusMalusRepository->add($bonusMalu, true);

            return $this->redirectToRoute('app_bonus_malus_index', [], Response::HTTP_SEE_OTHER);
        }

        $titulo  = $translator->trans('Bonus/Malus') . ' - ' . $translator->trans('Edit');

        return $this->renderForm('bonus_malus/edit.html.twig', [
            'bonus_malu' => $bonusMalu,
            'page_title' => $titulo,
            'active_section' => self::SIDEBAR_ID,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_bonus_malus_delete', methods: ['POST'])]
    public function delete(Request $request, BonusMalus $bonusMalu, BonusMalusRepository $bonusMalusRepository, TranslatorInterface $translator): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bonusMalu->getId(), $request->request->get('_token'))) {
            $bonusMalusRepository->remove($bonusMalu, true);
        }

        return $this->redirectToRoute('app_bonus_malus_index', [], Response::HTTP_SEE_OTHER);
    }
}
