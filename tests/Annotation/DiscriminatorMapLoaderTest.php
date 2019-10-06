<?php

declare(strict_types=1);

namespace Camelot\DoctrineInheritanceMapping\Tests\Annotation;

use Camelot\DoctrineInheritanceMapping\Annotation\DiscriminatorMapLoader;
use Camelot\DoctrineInheritanceMapping\Tests\DiscriminatorMapLoaderTrait;
use Camelot\DoctrineInheritanceMapping\Tests\Fixtures\Entity\SingleTable;
use Camelot\DoctrineInheritanceMapping\Tests\Fixtures\Entity\SingleTableChild;
use Camelot\DoctrineInheritanceMapping\Tests\Fixtures\Entity\SingleTableGrandchild;
use Doctrine\ORM\Mapping\ClassMetadata;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Camelot\DoctrineInheritanceMapping\Annotation\DiscriminatorMapLoader
 */
final class DiscriminatorMapLoaderTest extends TestCase
{
    use DiscriminatorMapLoaderTrait;

    public function testLoadClassMetadata(): array
    {
        $classMetadata = new ClassMetadata(SingleTable::class);
        $loader = $this->createDiscriminatorMapLoader();

        static::assertMetadata($classMetadata, $loader);

        return [$classMetadata, $loader];
    }

    /**
     * @depends testLoadClassMetadata
     */
    public function testLoadClassMetadataCaching($dependency): void
    {
        [$classMetadata, $loader] = $dependency;
        static::assertMetadata($classMetadata, $loader);
    }

    private static function assertMetadata(ClassMetadata $classMetadata, DiscriminatorMapLoader $loader)
    {
        $expected = [
            'SingleTable' => SingleTable::class,
            'SingleTableChild' => SingleTableChild::class,
            'SingleTableGrandchild' => SingleTableGrandchild::class,
        ];
        $loader->loadClassMetadata($classMetadata);

        static::assertSame($expected, $classMetadata->discriminatorMap);
    }
}
