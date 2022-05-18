<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/", name="app")
     */
    public function index() {
        return $this->redirectToRoute('app_login');
    }

    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_dashboard_index');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/aceptar/{user}", name="aceptar_usuario")
     */
    public function aceptarUser(User $user, EntityManagerInterface $entityManager) {
        try{
            $user->setAprobados(true);
            $entityManager->flush();
            return $this->redirectToRoute('app_dashboard_index');
        } catch(Exception $ex) {
            throw new \LogicException('Error en la Base de Datos');
        }
    }

    /**
     * @Route("/rechazar/{user}", name="rechazar_usuario")
     */
    public function rechazarUser(User $user, EntityManagerInterface $entityManager) {
        try{
            $user->setActivo(false);
            $entityManager->flush();
            return $this->redirectToRoute('app_dashboard_index');
        } catch(Exception $ex) {
            throw new \LogicException('Error en la Base de Datos');
        }
    }
}
