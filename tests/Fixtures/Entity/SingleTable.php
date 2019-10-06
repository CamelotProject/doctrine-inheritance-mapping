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
    /** @var UuidInterface|null */
    protected $id = null;
    /** @var string|null */
    protected $title = null;

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
