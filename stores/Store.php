<?php

interface store
{
    public function create(object $item): object;
    public function update(object $item): object;
    public function delete(string $id): void;
    public function findOne(string $id): object;
    public function findMany(array $ids): array;
    public function findAll(): array;
}
?>