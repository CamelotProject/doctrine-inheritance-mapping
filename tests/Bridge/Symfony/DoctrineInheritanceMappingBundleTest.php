<?php

declare(strict_types=1);

namespace Camelot\DoctrineInheritanceMapping\Tests\Bridge\Symfony;

use Camelot\DoctrineInheritanceMapping\Bridge\Symfony\DoctrineInheritanceMappingBundle;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

/**
 * @covers \Camelot\DoctrineInheritanceMapping\Bridge\Symfony\DoctrineInheritanceMappingBundle
 */
final class DoctrineInheritanceMappingBundleTest extends TestCase
{
    public function testBuild(): void
    {
        $bundle = new DoctrineInheritanceMappingBundle();
        $bundle->build(new ContainerBuilder(new ParameterBag([])));

        $this->addToAssertionCount(1);
    }
}
