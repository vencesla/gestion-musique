<?php
namespace App\Service;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadImageAlbum implements UploadFichierInterface{

    private $repertoireDestinationAlbum;

    public function __construct(String $repertoireDestinationAlbum){
        $this->repertoireDestinationAlbum = $repertoireDestinationAlbum;
    }

    /**
     * upload une image dans le dossier destination et retourne son nom ou null
     * 
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $fichier à uploader
     * @param string $repertoireDestination 
     * @param string $nomImageActuelle
     * @return string|null retourne le nouveau nom de l'image ou null
     */
    public function enregistrerImage(UploadedFile $fichier, String $nomImageActuelle)
    {
        // On récupère l'image sélectionnée
        if($fichier != null){
            // On supprime l'ancien fichier
            if($nomImageActuelle != 'pochettevierge.png'){
                \unlink(filename: $this->repertoireDestinationAlbum.$nomImageActuelle);
            }
            // On crée le nom du nouveau fichier
            $nouveauNomFichier = md5(\uniqid()).".".$fichier->getExtension();
            // On déplace le fichier dans le dossier public
            $fichier->move($this->repertoireDestinationAlbum, $nouveauNomFichier);
            return $nouveauNomFichier;
        }else{
            return null;
        }
    }
}