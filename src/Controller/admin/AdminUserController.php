<?php


// src/Controller/admin/AdminUserController.php

namespace App\Controller\admin;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class AdminUserController extends AbstractController
{
    #[Route('/admin/users', name: 'admin_users')]
    public function list(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();

        return $this->render('admin/users.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/admin/users/delete/{id}', name: 'admin_user_delete', methods: ['POST'])]
    public function delete(User $user, EntityManagerInterface $em, Request $request): Response
    {
        if ($this->isCsrfTokenValid('delete_user_' . $user->getId(), $request->request->get('_token'))) {
            $em->remove($user);
            $em->flush();
        }

        return $this->redirectToRoute('admin_users');
    }

 #[Route('/admin/users/promote/{id}', name: 'admin_user_promote', methods: ['POST'])]
public function promote(User $user, EntityManagerInterface $em, Request $request): Response
{
    if ($this->isCsrfTokenValid('promote_user_' . $user->getId(), $request->request->get('_token'))) {
        if (!in_array('ROLE_ADMIN', $user->getRoles())) {
            $user->promoteToAdmin();
            $em->flush();
            $this->addFlash('success', 'Utilisateur promu en admin ✅');
        } else {
            $this->addFlash('info', 'Cet utilisateur est déjà admin.');
        }
    }

    return $this->redirectToRoute('admin_users');
}


}

