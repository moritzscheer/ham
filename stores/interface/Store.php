<?php

namespace stores\interface;

interface Store
{
    public function delete(string $id);
    public function findOne(string $id);
    public function findAll();
}
