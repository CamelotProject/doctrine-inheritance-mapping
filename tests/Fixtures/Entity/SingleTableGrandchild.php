<?php

declare(strict_types=1);

namespace Camelot\DoctrineInheritanceMapping\Tests\Fixtures\Entity;

use Camelot\DoctrineInheritanceMapping\Annotation\DiscriminatorMapItem;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @DiscriminatorMapItem(value="SingleTableGrandchild")
 */
class SingleTableGrandchild extends SingleTableChild
{
    /** @var int|null */
    private $vitality = null;

    public function getVitality(): ?int
    {
        return $this->vitality;
    }

    public function setVitality(?int $vitality): SingleTableChild
    {
        $this->vitality = $vitality;

        return $this;
    }
}
