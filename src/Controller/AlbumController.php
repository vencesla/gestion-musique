<?php

namespace App\Controller;

use App\Repository\AlbumRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AlbumController extends AbstractController
{
    #[Route('/albums', name: 'albums')]
    public function listeAlbums(AlbumRepository $repo, PaginatorInterface $paginator, Request $request): Response
    {
        $albums = $paginator->paginate(
            $repo->listeAlbumsComplete(), /* query NOT result */
            $request->query->getInt('page', 1), /* page number */
            9 /* limit per page */
        );
        return $this->render('album/listeAlbums.html.twig', [
            'albums' => $albums
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
