<?php

namespace App\Controller;

use App\Entity\Recette;
use App\Repository\RecetteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

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
        $refere = $request->headers->get('referer');

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

        if(str_contains($refere,'details'))
        {
            return $this->redirectToRoute('showOneDetail_recettes',['id'=>$recette->getId()]);
        }
        else
        {
            return $this->redirectToRoute('showAll_recettes');
        }
    }

    #[Route('/recettes/filtre', name: 'setFiltre_recettes')]
    public function setFiltre(RecetteRepository $rr):Response
    {
        $listRecettes = $rr->findBy()

        return $this->json($listRecettes);
    }
}
