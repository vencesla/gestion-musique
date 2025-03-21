<?php

namespace App\Controller\Admin;

use App\Entity\Style;
use App\Form\StyleType;
use App\Repository\StyleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StyleController extends AbstractController
{
    #[Route('/admin/styles', name: 'admin_styles', methods:['GET'])]
    public function listeStyles(StyleRepository $repo): Response
    {
        return $this->render('admin/style/listeStyles.html.twig', [
            'styles' => $repo->listeStylesComplete(),
        ]);
    }

    #[Route('/admin/style/ajout', name: 'admin_style_ajout', methods:['GET', 'POST'])]
    #[Route('/admin/style/modif/{id}', name: 'admin_style_modif', methods:['GET', 'POST'])]
    public function ajoutStyle(int $id = null,StyleRepository $repo, Request $request, EntityManagerInterface $manager): Response
    {
        if($id == null){
            $mode = "ajouté";
            $style = new Style();
        }else{
            $mode = "modifié";
            $style = $repo->find($id);
        }
        $form = $this->createForm(StyleType::class, $style);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($style);
            $manager->flush();
            $this->addFlash('success', "Le style a bien été $mode");
            return $this->redirectToRoute('admin_styles');
        }
        return $this->render('admin/style/formAjoutModifStyle.html.twig', [
            'formStyle' => $form->createView(),
        ]);
    }

    #[Route('/admin/style/delete/{id}', name: 'admin_style_suppression', methods:['GET'])]
    public function suppressionStyle(int $id, StyleRepository $repo,EntityManagerInterface $manager): Response
    {
     
        $style = $repo->find($id);
        $nbAlbums = $style->getAlbums()->count();
        if($nbAlbums > 0){
            $this->addFlash('danger', "Vous ne pouvez pas supprimer ce style car $nbAlbums album(s) y sont associés");
        }else{
            $manager->remove($style);
            $manager->flush();
            $this->addFlash('success', "Le style a bien été supprimé");
        }
        
        return $this->redirectToRoute('admin_styles');
    }
}
