<?php

namespace App\Controller\guest;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AboutmeController extends AbstractController {

	#[Route('/apropos', name: "apropos")]
	public function displayHome() {
		return $this->render('guest/apropos.html.twig');
	}

	#[Route('/404', name: '404')]
	public function display404()
	{
		return $this->render('guest/404.html.twig');
	}
}