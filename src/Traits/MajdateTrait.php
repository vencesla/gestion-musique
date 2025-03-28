<?php
namespace App\Traits;
use Doctrine\ORM\Mapping as ORM;

trait MajdateTrait{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
    

    #[ORM\PrePersist]
    public function setAllDate():void
    {
        $this->createdAt = new \DateTimeImmutable;
        $this->updatedAt = new \DateTimeImmutable();
    }

     #[ORM\PreUpdate]
     /**
      * première méthode pour appeler un événement
      * @param \Doctrine\ORM\Event\PreUpdateEventArgs $args
      * @return void
      */
     public function changeUpdateValue():void
     {
         $this->updatedAt = new \DateTimeImmutable();
     }

}