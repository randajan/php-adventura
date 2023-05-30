<?php

session_start();

$DBhost = "10.10.0.10:3307";
$DBname = "php_adventura";
$DBuser = "php_adventura";
$DBpass = "Guwajip=71";
$URLroot = "/jarm12";

function getURL($path) {
    global $URLroot;
    return $URLroot."/".$path;
}

$db = new mysqli($DBhost, $DBuser, $DBpass, $DBname);

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