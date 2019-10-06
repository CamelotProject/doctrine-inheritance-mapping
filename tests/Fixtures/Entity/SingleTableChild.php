<?php

declare(strict_types=1);

namespace Camelot\DoctrineInheritanceMapping\Tests\Fixtures\Entity;

use Camelot\DoctrineInheritanceMapping\Annotation\DiscriminatorMapItem;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @DiscriminatorMapItem(value="SingleTableChild")
 */
class SingleTableChild extends SingleTable
{
    /** @var int|null */
    private $awesomeness = null;

    public function getAwesomeness(): ?int
    {
        return $this->awesomeness;
    }

    public function setAwesomeness(?int $awesomeness): SingleTableChild
    {
        $this->awesomeness = $awesomeness;

        return $this;
    }
}
