<?php

namespace App\Controller;

use App\Entity\Noticia;
use App\Form\NoticiaType;
use App\Repository\NoticiaRepository;
use App\Service\FileUploader;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FileUploadError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/noticia")
 */
class NoticiaController extends AbstractController
{
    /**
     * @Route("/new", name="app_noticia_new", methods={"POST"})
     */
    public function new(Request $request,EntityManagerInterface $entityManager, FileUploader $uploader): Response
    {
        $titulo = $request->get('titulo') ?? '';
        $medio = $request->get('medio') ?? '';
        $fecha = new DateTime($request->get('fecha')) ?? new DateTime();
        $file = $request->files->get('archivo') ?? null;

        $noticia = new Noticia();

        $noticia->setTitulo($titulo);
        $noticia->setMedio($medio);
        $noticia->setFecha($fecha);
        $noticia->setArchivo($file->getClientOriginalName());
        $entityManager->persist($noticia);
        $entityManager->flush();

        //$uploader->upload($uploadDir, $file, $filename);

        return $this->redirectToRoute('app_dashboard_index');
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
}
