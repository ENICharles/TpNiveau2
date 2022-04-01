<?php

namespace App\Controller;

use App\Entity\Recette;
use App\Repository\RecetteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecettesController extends AbstractController
{
    #[Route('/recettes', name: 'showAll_recettes')]
    public function showAll(RecetteRepository $rr): Response
    {
        $listRecettes = $rr->findAll();

        return $this->render('recettes/index.html.twig',compact('listRecettes'));
    }

    #[Route('/recettes/details/{id}', name: 'showOneDetail_recettes')]
    public function showOneDetail(RecetteRepository $rr,Recette $recette): Response
    {
        return $this->render('recettes/details.html.twig',compact('recette'));
    }



    #[Route('/recettes/favorite/{id}', name: 'setfavorite_recettes')]
    public function setfavorite(RecetteRepository $rr,EntityManagerInterface $em,Request $request,Recette $recette): Response
    {
        dd("couqsdhqms " . $request->getBaseUrl());

        if($recette->getEstFavori() == 0)
        {
            $recette->setEstFavori(1);

            $em->persist($recette);
            $em->flush();
        }
        else
        {
            $recette->setEstFavori(0);

            $em->persist($recette);
            $em->flush();
        }

        return $this->redirectToRoute('showOneDetail_recettes',['id'=>$recette->getId()]);
    }
}