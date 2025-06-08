<?php


namespace App\Controller\admin;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AdminUserController extends AbstractController {

	#[Route('/admin/create-user', name: 'admin-create-user', methods: ['GET', 'POST'])]
	public function displayCreateUser(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response{


		if ($request->isMethod('POST')) {

			$email = $request->request->get('email');
			$password = $request->request->get(key: 'password');

			$user = new User();

			$passwordHashed = $userPasswordHasher->hashPassword($user, $password);

			// méthode 1
			//$user->setPassword($passwordHashed);
			//$user->setEmail($email);
			// $user->setRoles(['ROLE_ADMIN']);

			// méthode 2 
			$user->createAdmin($email, $passwordHashed);

			try {
				$entityManager->persist($user);
				$entityManager->flush();
				$this->addFlash('success','Admin créé');
			} catch(Exception $exception) {

				$this->addFlash('error', 'Impossible de créer l\'admin');

				// si l'erreur vient de la clé d'unicité, je créé un message flash ciblé
				if ($exception->getCode() === 1062) {
					$this->addFlash('error',  'Email déjà pris.');
				}
				
			}


		}

		return $this->render('/admin/create-user.html.twig');

	}

    #[Route(path: '/admin/list-admins', name: 'admin-list-admins', methods: ['GET'])]
	public function displayListAdmins(UserRepository $userRepository) {

		$users = $userRepository->findAll();


        // Modifiez la création de l'utilisateur : quand l'utilisateur est créé, redirigez vers la liste des utilisateurs
		return $this->render('/admin/list-users.html.twig', [
			'users' => $users
		]);
	}

	#[Route('/admin/delete-user/{id}', name: 'admin-delete-user', methods: ['POST'])]
public function deleteUser(int $id, EntityManagerInterface $entityManager, UserRepository $userRepository): Response
{
    $user = $userRepository->find($id);

    if (!$user) {
        $this->addFlash('error', 'Utilisateur introuvable.');
        return $this->redirectToRoute('admin-list-admins');
    }

    $entityManager->remove($user);
    $entityManager->flush();

    $this->addFlash('success', 'Utilisateur supprimé avec succès.');

    return $this->redirectToRoute('admin-list-admins');
}




}