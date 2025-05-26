<?php

namespace App\Controller\guest;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TravelController extends AbstractController
{
    #[Route('/mytravels', name: 'mytravels')]
    public function index(): Response
    {
        $travels = [
            [
                'title' => 'Road trip en Écosse',
                'date' => new \DateTime('2024-07-15'),
                'image' => 'assets/img/scotland.jpg',
                'description' => 'Des lochs mystérieux, des châteaux perchés, et des routes sauvages à couper le souffle.'
            ],
            [
                'title' => 'Coucher de soleil à Santorin',
                'date' => new \DateTime('2023-08-10'),
                'image' => 'assets/img/santorini.jpg',
                'description' => 'Des maisons blanches et bleues surplombant la mer Égée. Une expérience magique.'
            ],
            [
                'title' => 'Découverte de Kyoto',
                'date' => new \DateTime('2022-11-05'),
                'image' => 'assets/img/kyoto.jpg',
                'description' => 'Temples zen, forêts de bambous et traditions japonaises dans une ville magnifique.'
            ],
        ];

        return $this->render('guest/mytravels.html.twig', [
            'travels' => $travels
        ]);
    }
}