<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    #[Route('/les_bonnes_pratiques', name: 'pratiques')]
    public function index(): Response
    {
        return $this->render('article/bonnes_pratiques.html.twig', [
            'controller_name' => 'ArticleController',
        ]);
    }
}
