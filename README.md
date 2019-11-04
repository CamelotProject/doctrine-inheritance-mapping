Camelot Doctrine Inheritance Mapping
====================================

Installation
------------

Open a command console, enter your project directory and execute:

```console
$ composer require camelot/doctrine-inheritance-mapping
```

This command requires you to have Composer installed globally, as explained
in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

### Standalone Configuration

```php
use Camelot\DoctrineInheritanceMapping\Annotation\DiscriminatorMapLoader;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\DocParser;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;

// Annotation reader & driver
$reader = new AnnotationReader(new DocParser());
$driver = new AnnotationDriver($reader);
$driver->addPaths(['/path/to/entities']);

// Doctrine configuration
$config = new Configuration();
$config->setMetadataDriverImpl($driver);

$classMetadata = new ClassMetadata(YourEntityName::class);

$loader = new DiscriminatorMapLoader($reader, $config);
$loader->loadClassMetadata($classMetadata);
```

### Framework Configuration

#### Symfony Bundle

If using the Symfony Framework, you can enable the bundle by adding it to the
list of registered bundles in the `config/bundles.php` file of your project:

```php
// config/bundles.php

return [
    // ...
    Camelot\DoctrineInheritanceMapping\Bridge\Symfony\DoctrineInheritanceMappingBundle::class => ['all' => true],
];
```

Usage
-----

### Single Table Inheritance 

#### `@DiscriminatorMapItem` Annotation

Doctrine's [Single Table Inheritance][single-table-inheritance] is an
inheritance mapping strategy where all classes of a hierarchy are mapped to a
single database table.

The mapping is handled by a "discriminator" column, defined in the mapping
definition of the parent class. This column value defines the entity class to
use, based on the inheritance hierarchy. This binds the parent to the children
and mixes responsibilities in the process. 

To separate these concerns, this library provides the `@DiscriminatorMapItem`
annotation for use in *each* entity in a hierarchy, replacing the parent class
use of Doctrine's `@DiscriminatorMap`, thus eliminating the need to update the
parent for each subclass.

##### Example

###### Parent Class

```php
<?php
namespace App\Entity;

use Camelot\DoctrineInheritanceMapping\Annotation\DiscriminatorMapItem;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @DiscriminatorMapItem(value="SingleTable")
 */
class SingleTable
{
    // ...
}

```

**NOTE:** Using `@DiscriminatorColumn` along with `@DiscriminatorMapItem` is
optional, and has been omitted above for clarity.

###### Child(ren) Class

```php
<?php
namespace App\Entity;

use Camelot\DoctrineInheritanceMapping\Annotation\DiscriminatorMapItem;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @DiscriminatorMapItem(value="SingleTableChild")
 */
class SingleTableChild extends SingleTable
{
    // ...
}
```
[single-table-inheritance]: https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/reference/inheritance-mapping.html#single-table-inheritance
