<?php

namespace App\Controller\profil;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class ProfilPageController extends AbstractController
{
    #[Route('/profil/home', name: "profil_home")]
    public function displayHome(Security $security): Response
    {
        $user = $security->getUser();

        return $this->render('profil/home.html.twig', [
            'email' => $user ? $user->getUserIdentifier() : 'invité',
        ]);
    }

    #[Route('/404', name: '404')]
    public function display404(): Response
    {
        return $this->render('guest/404.html.twig');
    }
}
