<?php

namespace Item;

class Item {



    /**
     * @param $result
     * @param $key
     * @param $value
     * @param $keyOrValue
     * @param $withApostroph
     * @return string
     */
    protected function concatList($result, $key, $value, $keyOrValue, $withApostroph): string
    {
        $attr = $keyOrValue === "value" ? $value : $key;
        if($withApostroph) {
            $attr = "'" . $attr . "'";
        }
        if ($value !== null && $value !== "") {
            if ($result === "") {
                $result = $attr;
            } else {
                $result = $result . ", " . $attr;
            }
        }
        return $result;
    }

    /**
     * @param $result
     * @param $key
     * @param $value
     * @param $separator
     * @return string
     */
    protected function concatSet($result, $key, $value, $separator): string
    {
        if ($result === "") {
            $result = $key . " = '" . $value . "'";
        } else {
            $result = $result . " " . $separator . " " . $key . " = '" . $value . "'";
        }
        return $result;
    }
}