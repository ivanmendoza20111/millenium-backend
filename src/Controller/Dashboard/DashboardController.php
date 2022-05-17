<?php

namespace App\Controller\Dashboard;

use App\Repository\NoticiaRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/dashboard")
 */
class DashboardController extends AbstractController
{
    /**
     * @Route("/", name="app_dashboard_index", methods={"GET"})
     */
    public function index(NoticiaRepository $noticiaRepository, UserRepository $userRepository): Response
    {
        $user = $userRepository->findBy(['activo' => true, 'aprobados'=> false]);

        return $this->render('dashboard/index.html.twig', [
            'noticias' => $noticiaRepository->findAll(),
            'users' => $user
        ]);
    }
}