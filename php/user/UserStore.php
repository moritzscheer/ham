<?php

interface UserStore {
    public function create($userFile);
    public function register($type_ID, $address_ID, $name, $surname, $password, $phone_number, $email);
    public function login($email, $password);
    public function delete($user_ID);
    public function update($user_ID, $list);
}