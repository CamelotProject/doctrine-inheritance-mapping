<?php

declare(strict_types=1);

namespace Camelot\DoctrineInheritanceMapping\Annotation;

use BadMethodCallException;

/**
 * @Annotation
 */
final class DiscriminatorMapItem
{
    private ?string $value;

    public function __construct(array $data)
    {
        static::assertValid($data);
        $this->value = $data['value'];
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    private static function assertValid(array $data): void
    {
        if (!($data['value'] ?? false)) {
            throw new BadMethodCallException(sprintf('Value for annotation DiscriminatorMapItem is missing or empty.'));
        }
    }
}
