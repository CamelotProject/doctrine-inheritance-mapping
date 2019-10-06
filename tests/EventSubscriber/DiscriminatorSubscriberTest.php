<?php

declare(strict_types=1);

namespace Camelot\DoctrineInheritanceMapping\Tests\EventSubscriber;

use Camelot\DoctrineInheritanceMapping\EventSubscriber\DiscriminatorSubscriber;
use Camelot\DoctrineInheritanceMapping\Tests\DiscriminatorMapLoaderTrait;
use Camelot\DoctrineInheritanceMapping\Tests\Fixtures\Entity\SingleTable;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Mapping\ClassMetadata;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Camelot\DoctrineInheritanceMapping\EventSubscriber\DiscriminatorSubscriber
 */
final class DiscriminatorSubscriberTest extends TestCase
{
    use DiscriminatorMapLoaderTrait;

    public function testGetSubscribedEvents(): void
    {
        $subscriber = $this->getDiscriminatorSubscriber();
        static::assertSame(['loadClassMetadata'], $subscriber->getSubscribedEvents());
    }

    public function testLoadClassMetadata(): void
    {
        $classMetadata = new ClassMetadata(SingleTable::class);
        $event = $this->createMock(LoadClassMetadataEventArgs::class);
        $event
            ->expects($this->once())
            ->method('getClassMetadata')
            ->willReturn($classMetadata)
        ;
        $subscriber = $this->getDiscriminatorSubscriber();
        $subscriber->loadClassMetadata($event);
    }

    private function getDiscriminatorSubscriber(): DiscriminatorSubscriber
    {
        return new DiscriminatorSubscriber($this->createDiscriminatorMapLoader());
    }
}
