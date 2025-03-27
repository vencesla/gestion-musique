<?php

namespace App\Form;

use App\Entity\Album;
use App\Entity\Artiste;
use App\Entity\Style;
use App\Repository\ArtisteRepository;
use App\Repository\StyleRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class AlbumType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'required' => false,
                'label' => "Nom de l'album",
                'attr' => [
                    'placeholder' => "Saisir le nom de l'album"
                ]
            ])
            ->add('date', IntegerType::class, [
                'required' => false,
                'label' => "Année de l'album"
            ])
            ->add('imageFile', FileType::class, [
                'mapped' => false,
                'required' => false,
                'label' => "Charger la pochette",
                'attr' => [
                    'accept' => ".jpg,.png"
                ],
                'row_attr' =>[
                    'class' => "d-none"
                ],
                'constraints' => [
                        new Image([
                            'maxSize' => '500k',
                            'maxSizeMessage' => "La taille maximum doit être de 500ko",
                            'mimeTypes' => [
                                'image/jpeg',
                                'image/png'
                            ]
                        ])
                ]
            ])
            ->add('image', HiddenType::class)
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
                'by_reference' => false,
                'attr' => [
                    'class' => "SelectStyles"
                ]

            ] )
            ->add("morceaux", CollectionType::class, [
                'entry_type' => MorceauType::class,
                'label' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Album::class,
        ]);
    }
}
