<?php 

namespace App\Listener;

use App\Entity\Style;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class EntityListener{
    /**
     * 
     * 2eme méthode pour appeler un évenement via service.yml
     * @param \App\Entity\Style $style
     * @param \Doctrine\Persistence\Event\LifecycleEventArgs $event
     * @return void
     */
    public function monPreUpdate(Style $style, LifecycleEventArgs $event){
        $style->setUpdatedAt(new \DateTimeImmutable());
    }
}