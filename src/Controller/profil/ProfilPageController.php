<?php

namespace App\Controller\profil;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilPageController extends AbstractController {

	#[Route('/profil/home', name: "profilhome")]
	public function displayHome() {
		return $this->render('profil/home.html.twig');
	}

	#[Route('/404', name: '404')]
	public function display404()
	{
		return $this->render('guest/404.html.twig');
	}
}