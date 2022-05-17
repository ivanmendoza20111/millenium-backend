<?php

namespace App\Controller;

use App\Entity\Noticia;
use App\Form\NoticiaType;
use App\Repository\NoticiaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/noticia")
 */
class NoticiaController extends AbstractController
{
    /**
     * @Route("/", name="app_noticia_index", methods={"GET"})
     */
    public function index(NoticiaRepository $noticiaRepository): Response
    {
        return $this->render('noticia/index.html.twig', [
            'noticias' => $noticiaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_noticia_new", methods={"GET", "POST"})
     */
    public function new(Request $request, NoticiaRepository $noticiaRepository): Response
    {
        $noticium = new Noticia();
        $form = $this->createForm(NoticiaType::class, $noticium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $noticiaRepository->add($noticium, true);

            return $this->redirectToRoute('app_noticia_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('noticia/new.html.twig', [
            'noticium' => $noticium,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_noticia_show", methods={"GET"})
     */
    public function show(Noticia $noticium): Response
    {
        return $this->render('noticia/show.html.twig', [
            'noticium' => $noticium,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_noticia_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Noticia $noticium, NoticiaRepository $noticiaRepository): Response
    {
        $form = $this->createForm(NoticiaType::class, $noticium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $noticiaRepository->add($noticium, true);

            return $this->redirectToRoute('app_noticia_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('noticia/edit.html.twig', [
            'noticium' => $noticium,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_noticia_delete", methods={"POST"})
     */
    public function delete(Request $request, Noticia $noticium, NoticiaRepository $noticiaRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$noticium->getId(), $request->request->get('_token'))) {
            $noticiaRepository->remove($noticium, true);
        }

        return $this->redirectToRoute('app_noticia_index', [], Response::HTTP_SEE_OTHER);
    }
}
