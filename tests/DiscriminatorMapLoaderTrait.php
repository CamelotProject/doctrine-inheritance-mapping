<?php

declare(strict_types=1);

namespace Camelot\DoctrineInheritanceMapping\Tests;

use Camelot\DoctrineInheritanceMapping\Annotation\DiscriminatorMapLoader;
use Doctrine\Common\Annotations\AnnotationException;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\DocParser;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;

trait DiscriminatorMapLoaderTrait
{
    private function createDiscriminatorMapLoader(): DiscriminatorMapLoader
    {
        try {
            $reader = new AnnotationReader(new DocParser());
        } catch (AnnotationException $e) {
            static::fail($e->getMessage());
        }
        $driver = new AnnotationDriver($reader);
        $driver->addPaths([__DIR__ . '/Fixtures/Entity']);
        $config = new Configuration();
        $config->setMetadataDriverImpl($driver);

        return new DiscriminatorMapLoader($reader, $config);
    }

    abstract public static function fail(string $message);
}
