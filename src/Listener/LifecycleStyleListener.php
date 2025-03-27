<?php 

namespace App\Listener;

use App\Entity\Style;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class LifecycleStyleListener{

    /**
     * 3eme façon de faire: via le service 
     * @param \Doctrine\Persistence\Event\LifecycleEventArgs $args
     * @return void
     */
    public function preUpdate(LifecycleEventArgs $args){
        $entity = $args->getObject();
        if(!$entity instanceof Style){
            return;
        }
        $entity->changeUpdateValue();
    }
}