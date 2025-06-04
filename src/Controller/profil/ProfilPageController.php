<?php

namespace App\Controller\profil;

use App\Entity\Experience;
use App\Entity\User;
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

        // Création d'une expérience
        if ($request->isMethod('POST') && !$request->request->has('_token')) {
            $experience = new Experience();
            $experience->setTitle($request->request->get('title'));
            $experience->setDescription($request->request->get('description'));
            $experience->setIsPublished($request->request->has('is-published'));
            $experience->setUser($user);

            $imageFile = $request->files->get('image');
            if ($imageFile) {
                $filename = uniqid().'.'.$imageFile->guessExtension();
                $imageFile->move($this->getParameter('kernel.project_dir').'/public/uploads', $filename);
                $experience->setImage($filename);
            }

            $em->persist($experience);
            $em->flush();

            $this->addFlash('success', sprintf(
                'Votre expérience a été créée. <a href="%s" class="flash-link-button">Voir mon profil</a>',
                $this->generateUrl('profil_user', ['id' => $user->getId()])
            ));

            return $this->redirectToRoute('profil_home');
        }

        $experiences = $em->getRepository(Experience::class)->findBy(['user' => $user]);

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

        $experiences = $em->getRepository(Experience::class)->findBy(['user' => $currentUser]);

        return $this->render('profil/user.html.twig', [
            'user' => $currentUser,
            'experiences' => $experiences,
        ]);
    }

    #[Route('/experience/delete/{id}', name: 'experience_delete', methods: ['POST'])]
    public function deleteExperience(int $id, EntityManagerInterface $em, Request $request): Response
    {
        $experience = $em->getRepository(Experience::class)->find($id);

        if (!$experience || $experience->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException("Accès refusé.");
        }

        if ($this->isCsrfTokenValid('delete_experience_' . $experience->getId(), $request->request->get('_token'))) {
            $em->remove($experience);
            $em->flush();
            $this->addFlash('success', 'L\'expérience a bien été supprimée.');
        }

        return $this->redirectToRoute('profil_home');
    }

    #[Route('/experience/edit/{id}', name: 'experience_edit')]
    public function editExperience(int $id, Request $request, EntityManagerInterface $em): Response
    {
        $experience = $em->getRepository(Experience::class)->find($id);

        if (!$experience || $experience->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException("Accès refusé.");
        }

        if ($request->isMethod('POST')) {
            $experience->setTitle($request->request->get('title'));
            $experience->setDescription($request->request->get('description'));
            $experience->setIsPublished($request->request->has('is-published'));

            $imageFile = $request->files->get('image');
            if ($imageFile) {
                $filename = uniqid().'.'.$imageFile->guessExtension();
                $imageFile->move($this->getParameter('kernel.project_dir').'/public/uploads', $filename);
                $experience->setImage($filename);
            }

            $em->flush();
            $this->addFlash('success', 'L\'expérience a bien été modifiée.');

            return $this->redirectToRoute('profil_home');
        }

        return $this->render('profil/edit.html.twig', [
            'experience' => $experience,
        ]);
    }
}

