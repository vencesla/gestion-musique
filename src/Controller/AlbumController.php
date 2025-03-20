<?php

namespace App\Controller;

use App\Repository\AlbumRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AlbumController extends AbstractController
{
    #[Route('/albums', name: 'albums')]
    public function listeAlbums(AlbumRepository $repo): Response
    {
        return $this->render('album/listeAlbums.html.twig', [
            'albums' => $repo->findBy(['date' => '2006'], ['nom' => 'ASC'], 5),
        ]);
    }

    #[Route('/album/fiche/{id}', name: 'album')]
    public function ficheAlbum(int $id,AlbumRepository $repo): Response
    {
        return $this->render('album/ficheAlbum.html.twig', [
            'album' => $repo->find($id)
        ]);
    }
}
