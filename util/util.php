<?php

// Util functions
function truncate_text($text, $max_length, $suffix = '...')
{
    if (strlen($text) > $max_length) {
        $text = substr($text, 0, $max_length - strlen($suffix)) . $suffix;
    }
    return $text;
}
