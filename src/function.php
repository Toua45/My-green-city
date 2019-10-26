<?php

function cleanInput(array $input) : array
{
    foreach ($input as $key => $value ) {
        $data[$key] = trim(htmlentities($value));
    }
    return $data;
}
