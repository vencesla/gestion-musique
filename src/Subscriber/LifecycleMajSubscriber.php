<?PHP

namespace App\Subscriber;

use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;


class LifecycleMajSubscriber implements EventSubscriberInterface
{
    public function getSubscribedEvents():array
    {
        return [
            Events::preUpdate,
           // Events::prePersist
        ];
    }

    public function preUpdate(LifecycleEventArgs $args){
        $entity = $args->getObject();
        if(!property_exists($entity, 'updatedAt')){
            return;
        }
        $entity->setUpdatedAt(new \DateTimeImmutable());
    }
}