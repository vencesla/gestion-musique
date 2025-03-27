<?php 

namespace App\Model;

use App\Entity\Artiste;
use Symfony\Component\Validator\Constraints as Assert;


class FiltreAlbum {

    #[Assert\Length(
        min: 2,
        minMessage: "Le nom de l'album doit comporter au minimum {{ limit }}"
    )]
    public $nom;
    public Artiste $artiste;
    public $styles;
}