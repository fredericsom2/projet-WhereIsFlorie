<?php

namespace App\Controller\guest;

// Importation de l'entité Experience (correspond à une expérience de voyage)
use App\Entity\Experience;

// Importation du repository pour interroger la base de données Experience
use App\Repository\ExperienceRepository;

// Contrôleur Symfony de base
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// Gestion de la requête HTTP (utile pour récupérer les paramètres GET, POST, etc.)
use Symfony\Component\HttpFoundation\Request;

// Gestion de la réponse HTTP
use Symfony\Component\HttpFoundation\Response;

// Annotation de routage Symfony
use Symfony\Component\Routing\Annotation\Route;

class AllTravelsController extends AbstractController
{
    // Route pour afficher toutes les expériences ou faire une recherche
    #[Route('/alltravels', name: 'alltravels')]
    public function index(Request $request, ExperienceRepository $repository): Response
    {
        // Récupère la valeur du paramètre "search" dans l'URL
        $search = $request->query->get('search');

        // Si un mot-clé de recherche est saisi, on filtre les résultats
        if ($search) {
            $experiences = $repository->createQueryBuilder('e')
                ->where('e.title LIKE :search OR e.description LIKE :search') // Recherche par titre ou description
                ->setParameter('search', '%' . $search . '%') // Recherche partielle (avec %)
                ->getQuery()
                ->getResult(); // Récupère les résultats
        } else {
            // Sinon, on affiche toutes les expériences
            $experiences = $repository->findAll();
        }

        // On rend la vue Twig en passant les expériences et le mot-clé de recherche
        return $this->render('guest/alltravels.html.twig', [
            'experiences' => $experiences,
            'search' => $search,
        ]);
    }

    // Route pour afficher une expérience spécifique grâce à son ID
    #[Route('/experience/{id}', name: 'experience_show')]
    public function show(Experience $experience): Response
    {
        // On rend la page de détails d'une expérience
        return $this->render('guest/experience_show.html.twig', [
            'experience' => $experience,
        ]);
    }
}




