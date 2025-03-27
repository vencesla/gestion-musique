<?php

namespace App\Form;

use App\Entity\Artiste;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class ArtisteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                "label" => "Nom de l'artiste",
                'attr' => [
                    "placeholder" => "Saisir le nom de l'artiste"
                ]
            ])
            ->add('description', TextareaType::class, [
                'attr' => ['class' => 'ckeditor'],
            ])
            ->add('site', UrlType::class)
            ->add('imageFile', FileType::class, [
                'mapped' => false,
                'required' => false,
                'label' => "Charger la photo",
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
            ->add('type', ChoiceType::class, [
                "choices" =>[
                    "solo" => 0,
                    "groupe" => 1
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Artiste::class,
        ]);
    }
}
