<?php

function responseOut($res) {
    return json_encode($res);
}

function str_starts_with ( $haystack, $needle ) {
    return strpos( $haystack , $needle ) === 0;
}