<?php

session_start();

$env = parse_ini_file("../.env");

$db = new mysqli($env["DBhost"], $env["DBuser"], $env["DBpass"], $env["DBname"]);

if ($db->connect_error) {
    die("Chyba při připojení k databázi: " . $db->connect_error);
}

function dbGetAll($tbln) {
    global $db;

    $result = $db->query("SELECT * FROM `$tbln`");
    return $result->fetch_array();
}

function dbGetWhere($tbln, $where) {
    global $db;

    $result = $db->query("SELECT * FROM `$tbln` WHERE $where");
    return $result->fetch_array();
}

function dbGetOne($tbln, $id) {
    return dbGetWhere($tbln, "`id`='$id'");
}