<?php

/** @generate-class-entries */

class SplMultiMap implements IteratorAggregate, Countable
{
    public function __construct() {}

    public function put(string $key, mixed $value): void {}

    public function putAll(string $key, array $values): void {}

    public function get(string $key): array {}

    public function remove(string $key, mixed $value): bool {}

    public function removeAll(string $key): bool {}

    public function replaceAll(string $key, array $values): void {}

    public function containsKey(string $key): bool {}

    public function containsValue(string $key, mixed $value): bool {}

    public function keys(): array {}

    public function values(): array {}

    public function isEmpty(): bool {}

    public function clear(): void {}

    public function count(): int {}

    public function getIterator(): Iterator {}
}
