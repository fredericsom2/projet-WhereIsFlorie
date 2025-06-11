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
    // Route pour afficher le formulaire d'inscription (méthode GET)
    #[Route('/register', name: 'register', methods: ['GET'])]
    public function showForm(): Response
    {
        // Affiche le template du formulaire d'inscription
        return $this->render('guest/register.html.twig');
    }

    // Route pour traiter les données du formulaire d'inscription (méthode POST)
    #[Route('/register', name: 'register_post', methods: ['POST'])]
    public function register(
        Request $request,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $passwordHasher
    ): Response {
        // Récupère les données envoyées par le formulaire
        $email = $request->request->get('email');
        $plainPassword = $request->request->get('password');

        // Vérifie que tous les champs sont remplis
        if (!$email || !$plainPassword) {
            $this->addFlash('error', 'Veuillez remplir tous les champs.');
            return $this->redirectToRoute('register');
        }

        // Vérifie si un utilisateur existe déjà avec cet email
        $existingUser = $em->getRepository(User::class)->findOneBy(['email' => $email]);
        if ($existingUser) {
            $this->addFlash('error', 'Compte déjà existant.');
            return $this->render('guest/register.html.twig', [
                'existing_email' => $email
            ]);
        }

        // Crée un nouvel utilisateur
        $user = new User();
        $user->setEmail($email);
        $user->setCreatedAt(new \DateTime()); // Date de création
        $user->setIsVerified(false); // Le compte n'est pas encore vérifié
        $user->setRoles(['ROLE_USER']); // Attribue le rôle par défaut

        // Hash le mot de passe avant de le stocker
        $hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);
        $user->setPassword($hashedPassword);

        // Enregistre l'utilisateur en base de données
        $em->persist($user);
        $em->flush();

        // Message de succès et redirection vers la page de connexion
        $this->addFlash('success', 'Compte créé avec succès. Connectez-vous maintenant !');
        return $this->redirectToRoute('login');
    }
}
