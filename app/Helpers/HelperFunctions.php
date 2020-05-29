<?php

function linearSearch($value, $array)
{
    $found = false;
    $index = 0;

    while (!$found && $index < count($array)) {
        if ($array[$index]->name == $value->name) {
            $found = true;
        } else {
            $index += 1;
        }
    }
    return $found;
}