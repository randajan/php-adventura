<?php

//HLAVNÍ STRÁNKA S KONFIGURACÍ A PŘÍSTUPEM DO DATABÁZE

//spuštění session
session_start();

//konfigurace serveru
$DBhost = "10.10.0.10:3307";
$DBname = "php_adventura";
$DBuser = "php_adventura";
$DBpass = "Guwajip=71";
$URLroot = "";

//seznam všech tabulek v databázi
$DBtables = [
    "vstr_scenes"=>"Místa",
    "vstr_users"=>"Uživatelé",
    "vstr_characters"=>"Postavy",
    "vstr_stuffs"=>"Věci",
    "vstr_characters_stuffs"=>"Věci postav",
    "vstr_characters_scenes"=>"Místa postav"
];

//upravuje url tak aby začínala adresou v URLroot
function getURL($path) {
    global $URLroot;
    return $URLroot."/".$path;
}

//vytváří instanci databáze
$db = new mysqli($DBhost, $DBuser, $DBpass, $DBname);

if ($db->connect_error) {
    die("Chyba při připojení k databázi: " . $db->connect_error);
}

//vrátí název tabulky z databáze (překlad)
function dbGetTitle($tbln) {
    global $DBtables;
    return $DBtables[$tbln] ?: $tbln;
}

//vrátí záznamy z tabulky $tbln, které splňují podmínku $where
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

//vrátí všechny záznamy z tabulky $tbln, které splňují podmínku, ale pouze sloupec `id`
function dbGetAllIdOnly($tbln, $where="") {
    global $db;

    $query = "SELECT id FROM `$tbln`";
    if ($where) { $query .= " WHERE $where"; }

    $result = $db->query($query);

    $ids = [];
    while ($row = $result->fetch_assoc()) { $ids[] = $row['id']; }

    return $ids;
}

//vrátí všechny záznamy z tabulky $tbln, které splňují podmínku $where
function dbGetAll($tbln, $where="") {
    return dbGetWhere($tbln, $where, false);
}

//vrátí pouze jeden záznam dle primary key ($id)
function dbGetOne($tbln, $id) {
    return dbGetWhere($tbln, "`id`='$id'", true);
}

//vytvoří nový záznam v tabulce $tbln z hodnot uložených ve $vals
function dbInsert($tbln, $vals) {
    global $db;

    $keys_str = "";
    $values_str = "";

    foreach ($vals as $key => $value) {
        if ($keys_str) { $keys_str .= ", "; }
        if ($values_str) { $values_str .= ", "; }

        $keys_str .= "`".$db->real_escape_string($key)."`";
        $values_str .= $value === NULL ? "NULL" : "'".$db->real_escape_string($value)."'";
    }

    $query = "INSERT INTO `$tbln` ($keys_str) VALUES ($values_str)";

    return $db->query($query);
}

//upravit stávající záznam dle $id v tabulce $tbln, pomocí hodnot $vals
function dbUpdate($tbln, $id, $vals) {
    global $db;

    $id = $db->real_escape_string($id);
    $update_str = "";
    foreach ($vals as $key => $value) {
        if ($update_str) { $update_str .= ", "; }
        $value_str = $value === NULL ? "NULL" : "'".$db->real_escape_string($value)."'";
        $update_str .= "`$key`=$value_str";
    }

    $query = "UPDATE `$tbln` SET $update_str WHERE `id`='$id'";

    return $db->query($query);
}

//smaže stávajćí záznam dle $id v tabulce $tbln
function dbDelete($tbln, $id) {
    global $db;

    $id = $db->real_escape_string($id);
    $query = "DELETE FROM `$tbln` WHERE id = '$id'";

    return $db->query($query);
}

//vyzvedne z databáze informace o nastavení sloupců (schématu) tabulky $tbln
function dbGetColumns($tbln) {
    global $db;

    $query = "SHOW COLUMNS FROM `$tbln`";
    $result = $db->query($query);

    $columns = [];
    while ($row = $result->fetch_assoc()) {
        $parsed = parseSqlType($row["Type"]);

        $row["Length"] = $parsed["length"];
        $row["Type"] = $parsed["type"];
        $row["AutoIncrement"] = strpos($row["Extra"], "auto_increment") !== false;

        $columns[] = $row;
    }

    return $columns;
}

//vyzvedne z databáze informace o nastavení sloupců (schématu) + zjistí nastavení tzv. foreign key (vazby)
function dbGetColumnsWithFK($tbln) {
    global $db;

    $columns = dbGetColumns($tbln);

    $query = "SELECT COLUMN_NAME, REFERENCED_TABLE_NAME 
              FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
              WHERE TABLE_SCHEMA = DATABASE() 
              AND TABLE_NAME = '$tbln' 
              AND REFERENCED_TABLE_NAME IS NOT NULL";
    $result = $db->query($query);

    $foreignKeys = [];
    while ($row = $result->fetch_assoc()) {
        $foreignKeys[$row['COLUMN_NAME']] = $row['REFERENCED_TABLE_NAME'];
    }

    foreach ($columns as &$column) {
        if (array_key_exists($column['Field'], $foreignKeys)) {
            $column['ForeignKey'] = $foreignKeys[$column['Field']];
        } else {
            $column['ForeignKey'] = null;
        }
    }

    return $columns;
}

//standardně je typ přímo z SQL zapsán jako např `varchar(16)` tato funkce rozebere zápis na typ a délku tj.: [ "type"=>"varchar", "length"=>"16" ]
function parseSqlType($typeStr) {
    $pattern = "/([a-z]+)\((\d+)\)/i"; //regulární výraz, který validuje originální typ z SQL
    preg_match($pattern, $typeStr, $matches);

    if (count($matches) == 3) {
        return [
            "type" => $matches[1],
            "length" => $matches[2]
        ];
    } else {
        return [
            "type" => $typeStr,
            "length" => null
        ];
    }
}

//přeindexuje dvou rozměrné pole dle zadaného klíče $key
function reindexByKey($array, $key="id") {
    $result = [];
    foreach ($array as $item) {
        if (isset($item[$key])) {
            $result[$item[$key]] = $item;
        }
    }
    return $result;
}