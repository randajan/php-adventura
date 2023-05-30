<?php

$env = parse_ini_file("../.env");

$db = new mysqli($env["DBhost"], $env["DBuser"], $env["DBpass"], $env["DBname"]);

function dbGetAll($tbln) {
    global $db;

    $result = $db->query("SELECT * FROM `$tbln`");
    return $result->fetch_array();
}

function dbGetOne($tbln, $id) {
    global $db;

    $result = $db->query("SELECT * FROM `$tbln` WHERE `id`='$id'");
    return $result->fetch_array();
}