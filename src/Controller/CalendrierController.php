<?php

namespace App\Controller;

use App\Entity\FruitsLegumes;
use App\Form\FruitsLegumesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CalendrierController extends AbstractController
{
    #[Route('/calendrier', name: 'calendrier')]
    public function affiche(): Response
    {
        return $this->render('calendrier/calendrier.html.twig', [
            'controller_name' => 'CalendrierController',
        ]);
    }
    #[Route('/calendrier/create', name: 'create')]
    public function creer(Request $request,EntityManagerInterface $entityManager ): Response
    {
        $produit = new FruitsLegumes();

        $form = $this->createForm(FruitsLegumesType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($produit);
            $entityManager->flush();

            return $this->redirectToRoute('calendrier', []);
        }
        // else
        // {
        //     return $this->redirectToRoute('create', []);
        // }
        return $this->render('calendrier/add.html.twig', [
            'formulaire' => $form->createView()
            ]);
    }
}
