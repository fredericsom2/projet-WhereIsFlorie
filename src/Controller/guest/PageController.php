<?php

namespace App\Controller\guest;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController {

	#[Route('/', name: "home")]
	public function displayHome() {
		return $this->render('guest/home.html.twig');
	}

	#[Route('/404', name: '404')]
	public function display404()
	{
		return $this->render('guest/404.html.twig');
	}



    #[Route('/mytravels', name: 'mytravels')]
    public function index(): Response
    {
        $destinations = [
            [
                'title' => 'Tokyo',
                'description' => 'Une ville futuriste mêlée de traditions japonaises fascinantes.',
                 'slug' => 'tokyo',
                 'image' => 'img/tokyo.jpg'
            ],
            [
                'title' => 'Martinique',
                'description' => 'Une île des Caraïbes avec plages paradisiaques et culture créole.',
                 'slug' => 'martinique',
                'image' => 'img/martinique.jpg'
            ],
			[
                'title' => 'Rome',
                'description' => 'Un joyau historique avec le Colisée, le Vatican et la dolce vita.',
                 'slug' => 'rome',
                'image' => 'img/rome.jpg'
            ],
            
            [
                'title' => 'Faro',
                'description' => 'Le charme du sud du Portugal, entre falaises dorées et ruelles anciennes.',
                 'slug' => 'faro',
                'image' => 'img/faro.jpg'
            ],

            [
                'title' => 'Île Maurice',
                'description' => 'Un paradis tropical avec lagons turquoise et montagne verdoyante.',
                 'slug' => 'maurice',
                'image' => 'img/maurice.jpg'
            ],
			
            [
                'title' => 'Fuerteventura',
                'description' => 'Une île des Canaries entre dunes, volcans et plages sauvages.',
                 'slug' => 'fuerteventura',
                'image' => 'img/fuerteventura.jpg'
            ],
        ];

        return $this->render('guest/mytravels.html.twig', [
            'destinations' => $destinations,
        ]);
    }
}

