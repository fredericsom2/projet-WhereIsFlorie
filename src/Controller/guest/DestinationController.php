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

    #[Route('/destinations/maurice', name: 'destination_maurice')]
    public function ileMaurice(): Response
    {
        return $this->render('guest/destinations/maurice.html.twig');
    }

    #[Route('/destinations/rome', name: 'destination_rome')]
    public function rome(): Response
    {
        return $this->render('guest/destinations/rome.html.twig');
    }

    #[Route('/destinations/faro', name: 'destination_faro')]
    public function faro(): Response
    {
        return $this->render('guest/destinations/faro.html.twig');
    }

    #[Route('/destinations/tokyo', name: 'destination_tokyo')]
    public function tokyo(): Response
    {
        return $this->render('guest/destinations/tokyo.html.twig');
    }

    #[Route('/destinations/fuerteventura', name: 'destination_fuerteventura')]
    public function fuerteventura(): Response
    {
        return $this->render('guest/destinations/fuerteventura.html.twig');
    }


    
}
