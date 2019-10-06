<?php

declare(strict_types=1);

namespace Camelot\DoctrineInheritanceMapping\Tests\Annotation;

use BadMethodCallException;
use Camelot\DoctrineInheritanceMapping\Annotation\DiscriminatorMapItem;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Camelot\DoctrineInheritanceMapping\Annotation\DiscriminatorMapItem
 */
final class DiscriminatorMapItemTest extends TestCase
{
    public function providerDiscriminatorMap(): iterable
    {
        yield 'Null value' => [['value' => null]];
        yield 'Empty value' => [['value' => '']];
    }

    /**
     * @dataProvider providerDiscriminatorMap
     */
    public function testInvalidData(array $data): void
    {
        $this->expectException(BadMethodCallException::class);
        $this->expectExceptionMessage('Value for annotation DiscriminatorMapItem is missing or empty');

        new DiscriminatorMapItem($data);
    }

    public function testGetValue(): void
    {
        $discriminatorMapItem = new DiscriminatorMapItem(['value' => 'foo']);

        static::assertSame('foo', $discriminatorMapItem->getValue());
    }
}
