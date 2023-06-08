<?php
include_once "../stores/Store.php";


interface UserStore extends Store {
    public function create(object $user): User;
    public function update(object $user): User;
    public function delete(string $user_ID);
    public function findOne(string $user_ID);
    public function findMany(array $user_IDs);
    public function findAll();
}