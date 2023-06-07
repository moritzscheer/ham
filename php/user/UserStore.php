<?php

interface UserStore {
    public function create($userFile);
    public function register($type, $address_ID, $name, $surname, $password, $phone_number, $email);
    public function login($email, $password);
    public function delete($user_ID);
    public function update($user_ID, $array);
    public function getImage($user_ID, $array);
    public function getImages($user_ID, $array);
}