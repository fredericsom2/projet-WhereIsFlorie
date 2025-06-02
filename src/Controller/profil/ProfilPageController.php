<?php

namespace App\Controller\profil;

use App\Entity\Experience;
use App\Entity\User; // ✅ nécessaire pour le @var
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilPageController extends AbstractController
{
    #[Route('/profil/home', name: "profil_home")]
    public function displayHome(Request $request, EntityManagerInterface $em): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        if (!$user) {
            return $this->redirectToRoute('login');
        }

        if ($request->isMethod('POST')) {
            $experience = new Experience();
            $experience->setTitle($request->request->get('title'));
            $experience->setDescription($request->request->get('description'));
            $experience->setIsPublished($request->request->has('is-published'));
            $experience->setUser($user); // 🔑 lien avec l'utilisateur

            $imageFile = $request->files->get('image');
            if ($imageFile) {
                $filename = uniqid().'.'.$imageFile->guessExtension();
                $imageFile->move($this->getParameter('kernel.project_dir').'/public/uploads', $filename);
                $experience->setImage($filename);
            }

            $em->persist($experience);
            $em->flush();
        }

        $experiences = $em->getRepository(Experience::class)->findBy([
            'user' => $user,
        ]);

        return $this->render('profil/home.html.twig', [
            'email' => $user->getUserIdentifier(),
            'experiences' => $experiences,
        ]);
    }

    #[Route('/profil/{id}', name: 'profil_user')]
    public function userProfil(int $id, EntityManagerInterface $em): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();

        if (!$currentUser || $currentUser->getId() !== $id) {
            throw $this->createAccessDeniedException("Accès refusé.");
        }

        $experiences = $em->getRepository(Experience::class)->findBy([
            'user' => $currentUser,
        ]);

        return $this->render('profil/user.html.twig', [
            'user' => $currentUser,
            'experiences' => $experiences,
        ]);
    }
}
