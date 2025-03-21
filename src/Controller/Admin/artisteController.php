<?php

namespace App\Controller\Admin;

use App\Form\ArtisteType;
use Proxies\__CG__\App\Entity\Artiste;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\ArtisteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class artisteController extends AbstractController
{
    #[Route('/admin/artistes', name: 'admin_artistes', methods:['GET'])]
    public function listeArtistes(ArtisteRepository $repo, PaginatorInterface $paginator,Request $request): Response
    {
        $artistes = $paginator->paginate(
            $repo->listeArtistesCompletePaginee(), /* query NOT result */
            $request->query->getInt('page', 1), /* page number */
            9 /* limit per page */
        );
        return $this->render('admin/artiste/listeArtistes.html.twig', [
            'artistes' => $artistes
        ]);
    }

    #[Route('/admin/artiste/ajout', name: 'admin_artiste_ajout', methods:['GET', 'POST'])]
    public function ajoutArtiste(Request $request, EntityManagerInterface $manager): Response
    {
        $artiste = new Artiste();
        $form = $this->createForm(ArtisteType::class, $artiste);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($artiste);
            $manager->flush();
            $this->addFlash('success', "L'artsite a bien été ajouté");
            return $this->redirectToRoute('admin_artistes');
        }
        return $this->render('admin/artiste/ajoutArtiste.html.twig',[
            'formArtiste' => $form->createView() 
        ]);
    }
}
