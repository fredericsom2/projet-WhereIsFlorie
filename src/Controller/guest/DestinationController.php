<?php


// src/Controller/guest/DestinationController.php

namespace App\Controller\guest;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DestinationController extends AbstractController
{
    #[Route('/destinations/martinique', name: 'destination_martinique')]
    public function martinique(): Response
    {
        return $this->render('guest/destinations/martinique.html.twig');
    }

    #[Route('/destinations/ile-maurice', name: 'destination_ile_maurice')]
    public function ileMaurice(): Response
    {
        return $this->render('guest/destinations/ile-maurice.html.twig');
    }

    #[Route('/destinations/tokyo', name: 'destination_tokyo')]
    public function tokyo(): Response
    {
        return $this->render('guest/destinations/tokyo.html.twig');
    }

    // Ajoute les 3 autres de la même façon
}
