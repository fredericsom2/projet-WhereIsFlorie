<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PromoteMeController extends AbstractController
{
    #[Route('/promote-me', name: 'promote_me')]
    public function promoteMe(EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->getUser();
        $roles = $user->getRoles();

        // Ajoute ROLE_ADMIN si absent
        if (!in_array('ROLE_ADMIN', $roles)) {
            $roles = array_unique(array_merge($roles, ['ROLE_ADMIN']));
            $user->setRoles($roles);
            $em->flush();

            return new Response("✅ Tu es maintenant admin !");
        }

        return new Response("ℹ️ Tu es déjà admin.");
    }
}


