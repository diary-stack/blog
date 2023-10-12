<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute("app_profil");
        }

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUserName = $authenticationUtils->getLastUsername();

        return $this->render("security/login.html.twig", [
            "error" => $error,
            "lastusername" => $lastUserName
        ]);
    }
    #[Route("/profil", name: "app_profil")]
    public function profil(): Response
    {
        return $this->render("security/profil.html.twig");
    }

    #[Route("/logout", name: "app_logout")]
    public function logout(): never
    {
        throw new \Exception("amboary le security.yaml");
    }
}
