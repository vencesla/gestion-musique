<?php

namespace App\Entity;

use App\Repository\AlbumRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AlbumRepository::class)]
#[UniqueEntity(
    fields: ['nom', 'artiste'],
    message: "Il ne peut exister deux albums de même nom"
)]
class Album
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le nom de l'artiste est obligatoire")]
    #[Assert\Length(
        min: 3,
        max:50,
        minMessage: "Le nom de l'album doit contenir au minimum {{limi}}",
        maxMessage: "Le nom de l'album doit contenir au maximum {{limi}}"
    )]
    private ?string $nom = null;

    #[ORM\Column]
    #[Assert\NotBlank()]
    #[Assert\Range(
        min:1940, 
        max: 2099,
        notInRangeMessage: "Vous devez saisir une année comprise entre {{min}} et {{max}}"
    )]
    private ?int $date = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\ManyToOne(inversedBy: 'albums')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(message: "Le nom de l'artiste est obligatoire")]
    private ?Artiste $artiste = null;

    #[ORM\OneToMany(mappedBy: 'album', targetEntity: Morceau::class, cascade:["persist"], orphanRemoval:true)]
    private Collection $morceaux;

    #[ORM\ManyToMany(targetEntity: Style::class, mappedBy: 'albums')]
    #[Assert\Count(min:1, minMessage: "Veillez sectionner un style où plus")]
    private Collection $styles;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->morceaux = new ArrayCollection();
        $this->styles = new ArrayCollection();
        $this->setUpdatedAt(new \DateTimeImmutable);
        $this->setImage("pochettevierge.png");
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id):static
    {
        $this->id = $id;
        return $this;
    }
    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDate(): ?int
    {
        return $this->date;
    }

    public function setDate(int $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getArtiste(): ?Artiste
    {
        return $this->artiste;
    }

    public function setArtiste(?Artiste $artiste): static
    {
        $this->artiste = $artiste;

        return $this;
    }

    /**
     * @return Collection<int, Morceau>
     */
    public function getMorceaux(): Collection
    {
        return $this->morceaux;
    }

    public function addMorceau(Morceau $morceau): static
    {
        if (!$this->morceaux->contains($morceau)) {
            $this->morceaux->add($morceau);
            $morceau->setAlbum($this);
        }

        return $this;
    }

    public function removeMorceau(Morceau $morceau): static
    {
        if ($this->morceaux->removeElement($morceau)) {
            // set the owning side to null (unless already changed)
            if ($morceau->getAlbum() === $this) {
                $morceau->setAlbum(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Style>
     */
    public function getStyles(): Collection
    {
        return $this->styles;
    }

    public function addStyle(Style $style): static
    {
        if (!$this->styles->contains($style)) {
            $this->styles->add($style);
            $style->addAlbum($this);
        }

        return $this;
    }

    public function removeStyle(Style $style): static
    {
        if ($this->styles->removeElement($style)) {
            $style->removeAlbum($this);
        }

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
