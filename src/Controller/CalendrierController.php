<?php

namespace App\Controller;

use App\Entity\FruitsLegumes;
use App\Form\FruitsLegumesType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\FruitsLegumesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CalendrierController extends AbstractController
{
    #[Route('/calendrier', name: 'calendrier')]
    public function affiche(FruitsLegumesRepository $repository): Response
    {
        $legumes = $repository->findBy(
                array('type' =>'légumes'),

            );;
        $fruits = $repository->findBy(
                array('type' =>'fruits'),

            );;
        
        return $this->render('calendrier/calendrier.html.twig', [
            'controller_name' => 'CalendrierController',
            'fruits' =>$fruits,
            'legumes'=>$legumes
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
        
        return $this->render('calendrier/add.html.twig', [
            'formulaire' => $form->createView()
            ]);
    }
    #[Route('/calendrier/{id}/delete', name: 'delete')]
    public function delete(FruitsLegumes $fruits_legumes, EntityManagerInterface $em) {
        $em->remove($fruits_legumes);
        $em->flush();

        return $this->redirectToRoute('calendrier');
    }
    #[Route('/calendrier/{id}/update', name: 'update')]
    public function edit(Request $request, FruitsLegumes  $fruits_legumes) {
        $form = $this->createForm(FruitsLegumesType::class, $fruits_legumes);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('calendrier', []);
        }

        return $this->renderForm('calendrier/edit.html.twig', [
            
            'formulaire' => $form,
        ]);
    }


}
