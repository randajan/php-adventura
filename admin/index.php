<?php

//HLAVNÍ STRÁNKA ADMINISTRÁTORSKÉHO ROZHRANNÍ

require_once("../tools/tags.php");
require_once("../tools/page.php");
require_once("../tools/components.php");

require_once("../db/db.php");
require_once("../admin/controls.php");

//důležité, hlídá jestli je uživatel admin pokud ne tak ho přesměruje pryč
require_once("../admin/firewall.php");

//zjistí jestli je vybraná některá tabulka a pokud není zobrazí seznam vŠech tabulek
if (!isset($_GET["table"])) {
    //vygeneruje seznam tabulek a ukončí stŕanku
    die(htmlPage("Admin",
        tag("div", ["class"=>"board"], 
            href("back", "", "Zpět do hry")
            .adminList()
        )
    ));
}

//nastavení globální proměnnou - jméno vybrané tabulky
$tableName = $_GET["table"];

//sesbírá úplné informace o všech sloupcích tabulky dle $tableName
$tableColumns = dbGetColumnsWithFK($tableName); 

//definice funkce, která validuje hodnoty přijaté při, úpravách nebo vložení záznamů
function fetchPostData($isUpdate=true) {
    global $tableColumns;

    $data = [];
    foreach ($tableColumns as $column) {
        $columnName = $column["Field"];
        $allowNull = $column['Null'] === 'YES'; // ověřuje jestli může sloupec být 'nic'

        //sloupec 'id' (primary key) jde upravit pouze pokud jde o vložení nového řádku a není nastaven auto increment
        if ($columnName === "id" && ($isUpdate || $column["AutoIncrement"])) { continue; } 
        $value = $_POST[$columnName];
        $data[$columnName] = (!$value && $allowNull) ? NULL : $value;
    }
    return $data;
}

//tlačítko akce (pokud na nějaké uživatel klikl) - může být insert, update nebo delete 
$action = isset($_POST["action"]) ? $_POST["action"] : "";

//upravuje záznam pokud je akce update
if ($action === "update") { dbUpdate($tableName, $_POST["id"], fetchPostData(true)); }
//přidává záznam pokud je akce insert
else if ($action === "insert") { dbInsert($tableName, fetchPostData(false)); }
//smaže záznam pokud je akce delete
else if ($action === "delete") { dbDelete($tableName, $_POST["id"]); }

//generátor samotné html stránky se seznamem řádků ve vybrané tabulce ($tableName)
die(htmlPage("Admin - ".dbGetTitle($tableName),
    tag("div", ["class"=>"board"], 
        href("back", "admin", "Zpět na seznam")
        .adminTable($tableName, $tableColumns, dbGetAll($tableName))
    )
));