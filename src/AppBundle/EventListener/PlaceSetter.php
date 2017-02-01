<?php

namespace AppBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use AppBundle\Entity\User;

class PlaceSetter
{
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        if ($entity instanceof User) {
            $place = $entityManager->getRepository("AppBundle:Place")->find(100);
            $entity->setPlace($place);
        }
    }
}