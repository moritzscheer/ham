<?php

interface store
{
    public function delete(string $id);
    public function findOne(string $id);
    public function findMany(array $ids);
    public function findAll();
}
?>