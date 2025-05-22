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
}