<?php

namespace Camelot\DoctrineInheritanceMapping\EventSubscriber;

use Camelot\DoctrineInheritanceMapping\Annotation\DiscriminatorMapLoader;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;

class DiscriminatorSubscriber implements EventSubscriber
{
    /** @var DiscriminatorMapLoader */
    private $loader;

    public function __construct(DiscriminatorMapLoader $loader)
    {
        $this->loader = $loader;
    }

    public function getSubscribedEvents(): iterable
    {
        return [Events::loadClassMetadata];
    }

    public function loadClassMetadata(LoadClassMetadataEventArgs $event): void
    {
        $this->loader->loadClassMetadata($event->getClassMetadata());
    }
}
