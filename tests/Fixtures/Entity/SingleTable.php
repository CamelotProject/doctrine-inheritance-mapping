<?php

namespace Camelot\DoctrineInheritanceMapping\Tests\Fixtures\Entity;

use Camelot\DoctrineInheritanceMapping\Annotation\DiscriminatorMapItem;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity()
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @DiscriminatorMapItem(value="SingleTable")
 */
class SingleTable
{
    protected ?UuidInterface $id = null;
    protected ?string $title = null;

    public function getId(): ?UuidInterface
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }
}
