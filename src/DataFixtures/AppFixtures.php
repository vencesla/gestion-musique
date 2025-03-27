<?php

namespace App\DataFixtures;

use App\Entity\Album;
use App\Entity\Artiste;
use App\Entity\Morceau;
use App\Entity\Style;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create("fr_FR");
        $styles = $this->chargerFichier("style.csv");
        foreach($styles as $value){
            $style = new Style();
            $style->setId($value[0])
                ->setNom($value[1])
                ->setCouleur($faker->safeColorName());
            $manager->persist($style);
            $this->addReference("style".$style->getId(), $style);
        }

        $artistes = $this->chargerFichier("artiste.csv");
        $genres = ["men", "women"];
        foreach($artistes as $value){
            $artiste = new Artiste();
            $artiste->setId(intval($value[0]))
                    ->setNom($value[1])
                    ->setDescription("<p>" .join("</p><p>",$faker->paragraphs(5)). "</p>")
                    ->setSite($faker->url())
                    ->setImage("user.png")
                    ->setType($value[2]);
            $manager->persist($artiste);
            $this->addReference("artiste".$artiste->getId(), $artiste);
        }

        $albums = $this->chargerFichier("album.csv");
        foreach($albums as $value){
            $album = new Album();
            $album->setId(intval($value[0]))
                ->setNom($value[1])
                ->setDate(intval($value[2]))
                ->addStyle($this->getReference('style'.$value[3]))
                ->setArtiste($this->getReference("artiste".$value[4]));
            $manager->persist($album);
            $this->addReference("album".$album->getId(), $album);

        }

        $morceaux = $this->chargerFichier("morceau.csv");
        foreach($morceaux as $value){
            $morceau = new Morceau();

            $morceau->setId(intval($value[0]))
                    ->setTitre($value[2])
                    ->setAlbum($this->getReference("album".$value[1]))
                    ->setPiste(intval($value[4]))
                    ->setDuree(date("i:s", $value[3]));
            $manager->persist($morceau);
        }
        $manager->flush();
    }

    public function chargerFichier($fichier) {
        $fichierArtisteCsv = fopen(__DIR__."/".$fichier, "r");
        //lecture du csv

        while(!feof($fichierArtisteCsv)){
            $data[] = fgetcsv($fichierArtisteCsv);
        }
        fclose($fichierArtisteCsv);
        return $data;
    }
}
