<?php

session_start();

$env = parse_ini_file("../.env");

$db = new mysqli($env["DBhost"], $env["DBuser"], $env["DBpass"], $env["DBname"]);

if ($db->connect_error) {
    die("Chyba při připojení k databázi: " . $db->connect_error);
}

function dbGetWhere($tbln, $where="", $singleRow=true) {
    global $db;

    $query = "SELECT * FROM `$tbln`";
    if ($where) { $query .= " WHERE $where"; }

    $result = $db->query($query);

    if ($singleRow) { return $result->fetch_array(); }

    $rows = [];
    while ($row = $result->fetch_array()) { $rows[] = $row; }

    return $rows;
}

function dbGetAll($tbln, $where="") {
    return dbGetWhere($tbln, $where, false);
}



function dbGetOne($tbln, $id) {
    return dbGetWhere($tbln, "`id`='$id'", true);
}