<?PHP

namespace App\Subscriber;

use App\Entity\Style;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;


class LifecycleStyleSubscriber implements EventSubscriberInterface
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
        if(!$entity instanceof Style){
            return;
        }
        dd("yes i'm");
        $entity->changeUpdateValue();
    }
}