<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface UploadFichierInterface{
    /**
     * upload une image dans le dossier destination et retourne son nom ou null
     * 
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $fichier à uploader
     * @param string $repertoireDestination 
     * @param string $nomImageActuelle
     * @return string|null retourne le nouveau nom de l'image ou null
     */
    public function enregistrerImage(UploadedFile $file,String $nomImageActuelle);
}