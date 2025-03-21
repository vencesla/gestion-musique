<?php

namespace App\Controller;

use App\Repository\ArtisteRepository;
use App\Entity\Artiste;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArtisteController extends AbstractController
{
    #[Route('/artistes', name: 'artistes', methods:['GET'])]
    public function listeArtistes(ArtisteRepository $repo): Response
    {
        return $this->render('artiste/listeArtistes.html.twig', [
            'artistes' => $repo->listeArtistes()
        ]);
    }

    #[Route('/artiste/{id}', name: 'artiste', methods:['GET'])]
    public function ficheArtiste(int $id, ArtisteRepository $repo): Response
    {
        return $this->render('artiste/ficheArtiste.html.twig', [
            'artiste' => $repo->find($id)
        ]);
    }
}
