<?php

namespace php\includes\items;

class Item {



    /**
     * @param $result
     * @param $key
     * @param $value
     * @param $keyOrValue
     * @param $withApostroph
     * @return string
     */
    protected function concatList($str, $key, $value, $keyOrValue, $withApostroph): string
    {
        $attr = $keyOrValue === "value" ? $value : $key;
        if($withApostroph) {
            $attr = "'" . $attr . "'";
        }
        if ($value !== null && $value !== "") {
            if ($str === "") {
                $str = $attr;
            } else {
                $str = $str . ", " . $attr;
            }
        }
        return $str;
    }

    /**
     * @param $result
     * @param $key
     * @param $value
     * @param $separator
     * @return string
     */
    protected function concatSet($str, $key, $value, $separator): string
    {
        if ($str === "") {
            $str = $key . " = '" . $value . "'";
        } else {
            $str = $str . " " . $separator . " " . $key . " = '" . $value . "'";
        }
        return $str;
    }
}