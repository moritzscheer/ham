<?php

interface ItemStore
{
    public function loadAll(): array;
    public function store(Item $item) : bool;
}