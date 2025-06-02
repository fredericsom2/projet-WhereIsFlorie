<?php

namespace App\Controller\guest;

use App\Entity\Experience;
use App\Repository\ExperienceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AllTravelsController extends AbstractController
{
    #[Route('/alltravels', name: 'alltravels')]
    public function index(Request $request, ExperienceRepository $repository): Response
    {
        $search = $request->query->get('search');

        if ($search) {
            $experiences = $repository->createQueryBuilder('e')
                ->where('e.titre LIKE :search OR e.contenu LIKE :search')
                ->setParameter('search', '%' . $search . '%')
                ->getQuery()
                ->getResult();
        } else {
            $experiences = $repository->findAll();
        }

        return $this->render('guest/alltravels.html.twig', [
            'experiences' => $experiences,
            'search' => $search,
        ]);
    }
}



