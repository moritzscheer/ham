<?php

interface ItemListDAO
{
    /**
     * @param $type
     * @return Item[]
     */
    public function loadItems($type) : array;
    public function storeItem(Item $item): bool;
}
?>