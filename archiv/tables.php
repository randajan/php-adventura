<?php

function tag($tagName, $value) {
    return "<$tagName>$value</$tagName>";
}

function createLi($key, $value) {
    return tag("li", $key." : ".$value);
}

function createList(Array $array) {
    //ul = unordered list
    //li = list item

    $result = "";

    foreach ($array as $k=>$v) {
        $result .= createLi($k, $v);
    }

    // $count = 0;

    // while (true) {
    //     echo("tick:$count");
    //     $count = $count + 1;
    //     if ($count == 5) { break; }
    // }

    return tag("ul", $result);
}