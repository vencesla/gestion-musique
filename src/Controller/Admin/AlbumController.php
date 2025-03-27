<?php

namespace App\Controller\Admin;

use App\Entity\Album;
use App\Form\AlbumType;
use App\Form\FiltreAlbumType;
use App\Model\FiltreAlbum;
use App\Repository\AlbumRepository;
use App\Service\UploadFichierInterface;
use App\Service\UploadImage;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AlbumController extends AbstractController
{
    #[Route('/admin/albums', name: 'admin_albums')]
    public function listeAlbums(AlbumRepository $repo, PaginatorInterface $paginator, Request $request): Response
    {
        $filtre = new FiltreAlbum();
        $formFiltreAlbum = $this->createForm(FiltreAlbumType::class, $filtre);
        $formFiltreAlbum->handleRequest($request);
        $albums = $paginator->paginate(
            $repo->listeAlbumsCompletePagination($filtre),
            $request->query->getInt('page', 1),
            9
        );
        return $this->render('admin/album/listeAlbums.html.twig', [
            'albums' => $albums,
            'formFiltreAlbum' => $formFiltreAlbum->createView()
        ]);
    }

    #[Route('/admin/album/modif/{id}', name: 'admin_album_modif', methods:['GET', 'POST'])]
    #[Route('/admin/album/ajout', name: 'admin_album_ajout', methods:['GET', 'POST'])]
    public function ajoutModifAlbum(int|null $id, AlbumRepository $repo, Request $request,UploadFichierInterface $fichierImageAlbum, EntityManagerInterface $manager): Response
    {
        if($id == null){
            $album = new Album();
            $mode = "ajouté";
        }else{
            $mode = "modifié";
            $album = $repo->find($id);
        }
        $form = $this->createForm(AlbumType::class, $album);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
             // On récupère l'image sélectionnée
             if($form->get('imageFile')->getData() != null){
                $nouveauNomImage= $fichierImageAlbum->enregistrerImage($form->get('imageFile')->getData(),$album->getImage());
                if($nouveauNomImage != null) {
                    $album->setImage($nouveauNomImage);
                }
             }
            
            $manager->persist($album);
            $manager->flush();
            $this->addFlash('success', "L'album a bien été $mode");
            return $this->redirectToRoute('admin_albums');
        }
        return $this->render('admin/album/formAjoutModifAlbum.html.twig',[
            'formAlbum' => $form->createView() 
        ]);
    }

    #[Route('/admin/album/delete/{id}', name: 'admin_album_suppression', methods:['GET'])]
    public function suppressionAlbum(int $id, AlbumRepository $repo,EntityManagerInterface $manager): Response
    {
     
        $album = $repo->find($id);
        $nbMorceaux = $album->getMorceaux()->count();
        if($nbMorceaux > 0){
            $this->addFlash('danger', "Vous ne pouvez pas supprimer cet album car il est associé à $nbMorceaux morceau(x)");
        }else{
            $manager->remove($album);
            $manager->flush();
            $this->addFlash('success', "L'album a bien été supprimé");
        }
        
        return $this->redirectToRoute('admin_albums');
    }
}
