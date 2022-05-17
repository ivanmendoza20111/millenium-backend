<?php

namespace App\Controller\Noticia;

use App\Entity\Noticia;
use App\Form\NoticiaType;
use App\Repository\NoticiaRepository;
use App\Service\FileUploader;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FileUploadError;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
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
        
        if($file) {
            $noticia = $uploader->upload($file, $noticia);
        }

        $entityManager->persist($noticia);
        $entityManager->flush();

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

    /**
     * @Route("/download/{id}", name="app_noticia_download", methods={"GET"})
     */
    public function downloadFile(Noticia $noticium) {
        $path = $noticium->getPath().'/'.$noticium->getFilename();

        $response = new BinaryFileResponse($path);
            $response->trustXSendfileTypeHeader();
            $response->headers->set('Content-Type', 'application/vnd.ms-excel');
            $response->setContentDisposition(
                ResponseHeaderBag::DISPOSITION_ATTACHMENT,
                basename($path),
                iconv('UTF-8', 'ASCII//TRANSLIT', basename($path))
        );

        return $response;
    }
}
