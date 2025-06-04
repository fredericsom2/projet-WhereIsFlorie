<?php


// src/Controller/MyTravelsController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MytravelsController extends AbstractController
{
    #[Route('/mytravels', name: 'app_my_travels')]
    public function index(): Response
    {
        $destinations = [
            [
                'title' => 'Tokyo',
                'description' => 'Une ville futuriste mêlée de traditions japonaises fascinantes.',
                'image' => 'images/tokyo.jpg'
            ],
            [
                'title' => 'Martinique',
                'description' => 'Une île des Caraïbes avec plages paradisiaques et culture créole.',
                'image' => 'images/martinique.jpg'
            ],
            [
                'title' => 'Faro',
                'description' => 'Le charme du sud du Portugal, entre falaises dorées et ruelles anciennes.',
                'image' => 'images/faro.jpg'
            ],
            [
                'title' => 'Rome',
                'description' => 'Un joyau historique avec le Colisée, le Vatican et la dolce vita.',
                'image' => 'images/rome.jpg'
            ],
            [
                'title' => 'Île Maurice',
                'description' => 'Un paradis tropical avec lagons turquoise et montagne verdoyante.',
                'image' => 'images/ile-maurice.jpg'
            ],
            [
                'title' => 'Fuerteventura',
                'description' => 'Une île des Canaries entre dunes, volcans et plages sauvages.',
                'image' => 'images/fuerteventura.jpg'
            ],
        ];

        return $this->render('guest/mytravels.html.twig', [
            'destinations' => $destinations,
        ]);
    }
}
