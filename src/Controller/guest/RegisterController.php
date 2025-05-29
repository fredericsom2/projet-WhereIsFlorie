<?php

namespace App\Controller\guest;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterController extends AbstractController
{
    #[Route('/register', name: 'register', methods: ['GET'])]
    public function showForm(): Response
    {
        return $this->render('guest/register.html.twig');
    }

    #[Route('/register', name: 'register_post', methods: ['POST'])]
    public function register(
        Request $request,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $passwordHasher
    ): Response {
        $email = $request->request->get('email');
        $plainPassword = $request->request->get('password');

        if (!$email || !$plainPassword) {
            $this->addFlash('error', 'Veuillez remplir tous les champs.');
            return $this->redirectToRoute('register');
        }

        $existingUser = $em->getRepository(User::class)->findOneBy(['email' => $email]);
        if ($existingUser) {
            $this->addFlash('error', 'Compte déjà existant.');

            return $this->render('guest/register.html.twig', [
                'existing_email' => $email
            ]);
        }

        $user = new User();
        $user->setEmail($email);
        $user->setCreatedAt(new \DateTime());
        $user->setIsVerified(false);
        $user->setRoles(['ROLE_USER']);

        $hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);
        $user->setPassword($hashedPassword);

        $em->persist($user);
        $em->flush();

        $this->addFlash('success', 'Compte créé avec succès. Connectez-vous maintenant !');
        return $this->redirectToRoute('login');
    }
}
