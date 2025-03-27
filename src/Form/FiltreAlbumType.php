<?php

namespace App\Form;

use App\Entity\Artiste;
use App\Entity\Style;
use App\Model\FiltreAlbum;
use App\Repository\ArtisteRepository;
use App\Repository\StyleRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FiltreAlbumType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => [
                    'placeholder' => "Saisir une partie du nom de l'album recherché"
                ],
                'required' => false,
                'label' => "Recherche sur le nom de l'album"
            ])
            ->add('artiste', EntityType::class,[
                'label' => "Nom de l'artiste",
                'class' => Artiste::class,
                'query_builder' => function(ArtisteRepository $repo){
                    return $repo->artisteListeSimple();
                },
                'choice_label' => 'nom',
                'expanded' => false,
                'multiple' => false,
                'required' => false
            ])
            ->add('styles', EntityType::class, [
                'label' => "Style(s)",
                'class' => Style::class,
                'query_builder' => function(StyleRepository $repo){
                    return $repo->styleListeSimple();
                },
                'choice_label' => 'nom',
                'expanded' => false,
                'multiple' => true,
                'required' => false,
                'attr' => [
                    'class' => "SelectStyles"
                ]

            ] )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            'method' => 'get',
            'csrf_protection' => false,
            'data_class' => FiltreAlbum::class
        ]);
    }
}
