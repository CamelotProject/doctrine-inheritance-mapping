<?php

declare(strict_types=1);

namespace Camelot\DoctrineInheritanceMapping\Tests\Bridge\Symfony\DependencyInjection;

use Camelot\DoctrineInheritanceMapping\Annotation\DiscriminatorMapLoader;
use Camelot\DoctrineInheritanceMapping\Bridge\Symfony\DependencyInjection\DoctrineInheritanceMappingExtension;
use Camelot\DoctrineInheritanceMapping\EventSubscriber\DiscriminatorSubscriber;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

/**
 * @covers \Camelot\DoctrineInheritanceMapping\Bridge\Symfony\DependencyInjection\DoctrineInheritanceMappingExtension
 */
final class DoctrineInheritanceMappingExtensionTest extends TestCase
{
    public function testLoad(): void
    {
        $parameters = new ParameterBag();
        $container = new ContainerBuilder($parameters);
        $extension = new DoctrineInheritanceMappingExtension();
        $extension->load([], $container);

        static::assertArrayHasKey(DiscriminatorMapLoader::class, $container->getDefinitions());
        static::assertArrayHasKey(DiscriminatorSubscriber::class, $container->getDefinitions());
    }
}
