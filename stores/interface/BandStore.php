<?php
include_once "../stores/Store.php";

interface BandStore extends Store {
    public function create(Band $item): Band;
    public function update(Band $item): Band;
    public function findOne(string $id): Band;
}