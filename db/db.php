<?php

session_start();

$DBhost = "10.10.0.10:3307";
$DBname = "php_adventura";
$DBuser = "php_adventura";
$DBpass = "Guwajip=71";
$URLroot = "";

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

function dbInsert($tbln, $vals) {
    global $db;

    $keys_str = "";
    $values_str = "";

    foreach ($vals as $key => $value) {
        if ($keys_str) { $keys_str .= ", "; }
        if ($values_str) { $values_str .= ", "; }

        $keys_str .= "`".$db->real_escape_string($key)."`";
        $values_str .= "'".$db->real_escape_string($value)."'";
    }

    $query = "INSERT INTO `$tbln` ($keys_str) VALUES ($values_str)";

    return $db->query($query);
}

function dbUpdate($tbln, $id, $vals) {
    global $db;

    $id = $db->real_escape_string($id);
    $update_str = "";
    foreach ($vals as $key => $value) {
        if ($update_str) { $update_str .= ", "; }
        $update_str .= "`$key`='".$db->real_escape_string($value)."'";
    }

    $query = "UPDATE `$tbln` SET $update_str WHERE `id`='$id'";

    return $db->query($query);
}