<?php
include_once "../stores/interface/Store.php";


interface UserStore extends Store {
    public function create(User $user): User;
    public function update(User $user): User;
    public function delete(string $user_ID);
    public function findOne(string $user_ID);
}