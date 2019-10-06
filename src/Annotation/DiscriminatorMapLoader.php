<?php

declare(strict_types=1);

namespace Camelot\DoctrineInheritanceMapping\Annotation;

use Doctrine\Common\Annotations\Reader;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Persistence\Mapping\Driver\MappingDriver;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\Mapping\ClassMetadata;
use ReflectionClass;
use RuntimeException;

/**
 * Based on work by Jasper Kuperus <github@jasperkuperus.nl>
 */
final class DiscriminatorMapLoader
{
    private Reader $reader;
    private MappingDriver $mappingDriver;
    private array $cachedMap;

    public function __construct(Reader $reader, Configuration $config)
    {
        $this->reader = $reader;
        $this->mappingDriver = $config->getMetadataDriverImpl();
        $this->cachedMap = [];
    }

    public function loadClassMetadata(ClassMetadata $classMetadata): void
    {
        $map = new ArrayCollection();
        $class = $classMetadata->name;

        if (array_key_exists($class, $this->cachedMap)) {
            $this->overrideMetadata($classMetadata, $class);

            return;
        }
        $this->extractEntry($map, $class);
        if (!$map->containsKey($class)) {
            return;
        }
        $this->checkFamily($map, $class);
        $this->createEntries($map);
        $this->overrideMetadata($classMetadata, $class);
    }

    private function createEntries(Collection $map)
    {
        $discriminatorMap = array_flip($map->toArray());
        foreach ($map as $className => $discriminatorItem) {
            $this->cachedMap[$className]['map'] = $discriminatorMap;
            $this->cachedMap[$className]['discr'] = $map->get($className);
        }
    }

    /**
     * Set the discriminator map, discr value & subclasses
     */
    private function overrideMetadata(ClassMetadata $classMetadata, $class)
    {
        $classMetadata->discriminatorMap = $this->cachedMap[$class]['map'];
        $classMetadata->discriminatorValue = $this->cachedMap[$class]['discr'];
        if (isset($this->cachedMap[$class]['isParent']) && true === $this->cachedMap[$class]['isParent']) {
            $subclasses = $this->cachedMap[$class]['map'];
            unset($subclasses[$this->cachedMap[$class]['discr']]);
            $classMetadata->subClasses = array_values($subclasses);
        }
    }

    /**
     * Build the whole map.
     *
     * @throws \ReflectionException
     */
    private function checkFamily(Collection $map, string $class): void
    {
        $rc = new ReflectionClass($class);
        $parent = $rc->getParentClass() ? $rc->getParentClass()->name : null;
        if ($parent !== null) {
            $this->checkFamily($map, $parent);
        }
        $this->cachedMap[$class]['isParent'] = true;
        $this->checkChildren($map, $class);
    }

    private function checkChildren(Collection $map, string $class): void
    {
        foreach ($this->mappingDriver->getAllClassNames() as $name) {
            $childRc = new ReflectionClass($name);
            $classParent = $childRc->getParentClass() ? $childRc->getParentClass()->name : null;
            if (!$classParent) {
                continue;
            }
            if ($map->containsKey($name) || $classParent !== $class) {
                 continue;
             }
            $this->extractEntry($map, $name);
            $this->checkChildren($map, $name);
        }
    }

    private function extractEntry(Collection $map, string $class): void
    {
        $rc = new ReflectionClass($class);
        foreach ($this->reader->getClassAnnotations($rc) as $annotation) {
            if (!$annotation instanceof DiscriminatorMapItem) {
                continue;
            }
            $value = $annotation->getValue();
            if ($map->containsKey($value)) {
                throw new RuntimeException(sprintf("Found duplicate discriminator map entry '%s' in %s", $value, $class));
            }
            $map->set($class, $value);
        }
    }
}
