<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RedirectController extends AbstractController
{
  #[Route('/redirect', name: 'app_redirect_after_login')]
public function redirectAfterLogin(): Response
{
    /** @var \App\Entity\User $user */
    $user = $this->getUser();

    if (!$user) {
        return $this->redirectToRoute('login');
    }

    return $this->redirectToRoute('profil_user', [
        'id' => $user->getId(),
    ]);
}
}