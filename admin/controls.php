<?php

//OVLÁDACÍ PRVKY ADMINISTRÁTORSKÉHO ROZHRANNÍ

require_once("../tools/tags.php");
require_once("../tools/page.php");
require_once("../tools/components.php");

require_once("../db/db.php");
require_once("../game/user.php");

//generuje html jednoduchého políčka, přihlíží se k délce
function adminInput($column, $value) {
    $columnName = $column['Field'];
    $columnType = $column["Type"];
    $columnAI = $column["AutoIncrement"];

    $attr = [
        "type"=>"text",
        "name"=>$columnName,
        "value"=>$value != null ? $value : $column["Default"],
        "class"=>"dbfield",
        "size"=>$column["Length"],
        "data-dbtype"=>$columnType
    ];

    if ($column['Null'] !== 'YES') { $attr["required"] = ""; }

    //sloupec 'id' (primary key) jde upravit pouze pokud jde o vložení nového řádku a není nastaven auto increment
    if ($columnName === "id" && ($value || $columnAI)) { $attr["readonly"] = ""; }

    return tag("input", $attr, "", false);
}

//generuje html políčka ve kterém jde vybírat z možností $options
function adminSelect($column, $value, $options) {
    $columnName = $column['Field'];
    $allowNull = $column['Null'] === 'YES';

    $attr = [
        "name" => $columnName,
        "class" => "dbfield",
    ];

    $optionTags = "";

    //vytváří možnost nevybrat nic, používá se k tomu znak -
    if ($allowNull) {
        $optionAttrs = ["value" => ""];
        if ($value === NULL) { $optionAttrs["selected"] = ""; } 
        $optionTags .= tag("option", $optionAttrs, "-");
    }

    foreach ($options as $optionText) {
        $optionAttrs = ["value" => $optionText];
        if ($optionText === $value) { $optionAttrs["selected"] = ""; }
        $optionTags .= tag("option", $optionAttrs, $optionText);
    }

    return tag("select", $attr, $optionTags);
}

//generuje html pro velké pole - delší text
function adminTextarea($column, $value) {
    $columnName = $column['Field'];
    $columnType = $column["Type"];
    $columnAI = $column["AutoIncrement"];

    $attr = [
        "name" => $columnName,
        "class" => "dbfield",
        "rows" => "5",
        "cols" => $column["Length"],
        "data-dbtype" => $columnType
    ];

    if ($columnName === "id") { $attr["required"] = ""; }
    if ($columnName === "id" && $columnAI) { $attr["readonly"] = ""; }

    return tag("textarea", $attr, $value, true, true);
}

//generuje html pro celý řádek v tabulce, každý řádek je zároveň html formulář s tlačítky pro úpravu/odstranění a nebo pro přidání
function adminRow($table, $columns, $row=null, $foreignData=[]) {
    $result = "";
    
    foreach ($columns as $column) {
        $value = $row ? $row[$column["Field"]] : "";
        $type = $column["Type"];
        $cfk = $column["ForeignKey"];

        //rozhoduje se dle typy jaké políčko vytvoří
        if ($cfk) { $field = adminSelect($column, $value, $foreignData[$cfk]); }
        else if ($type === "longtext" || $type === "text") { $field = adminTextarea($column, $value); }
        else { $field = adminInput($column, $value); }
        
        $result .= tag("td", [], $field);
    }

    
    $action = $row ? "update" : "insert";
    $result .= tag("td", [], tag("input", ["type"=>"submit", "name"=>"action", "value"=>$action], "", false));

    //přidá tlačítko pro smazání pokud tento řádek je pro existující záznam
    if ($row) { $result .= tag("td", [], tag("input", [
        "type"=>"submit", "name"=>"action", "value"=>"delete",
        "onclick" => "return confirm('Opravdu smazat?');" //jediný pouzitý javascript slouží pro potvrzení smazání
    ], "", false)); }

    return tag("form", ["method"=>"POST", "action"=>getURL("admin/?table=$table")], tag("tr", [], $result));
}

//generuje html pro celou tabulku úprav, mazání a vytváření záznamů
function adminTable($table, $columns, $rows) {

    // Generuje hlavičku tabulky
    $thead = "";
    $foreignData = [];
    foreach ($columns as $column) {
        $cfk = $column["ForeignKey"];
        if ($cfk && !isset($foreignData[$cfk])) {
            $foreignData[$cfk] = dbGetAllIdOnly($cfk);
        }
        $thead .= tag("th", "", $column['Field']);
    }

    $tbody = "";

    //vytváří html pro každý existující řádek v tabulce
    foreach ($rows as $row) { $tbody .= adminRow($table, $columns, $row, $foreignData); }

    //vytváří poslední řádek, který slouží pro přidávání nových záznamů
    $tbody .= adminRow($table, $columns, null, $foreignData);

    return tag("table", [], tag("thead", [], $thead).tag("tbody", [], $tbody));
}

//generuje html pro seznam jednotlivých tabulek v databázi
function adminList() {
    global $DBtables;

    $result = "";
    foreach($DBtables as $name=>$title) {
        $result .= tag("li", [], tag("a", ["href"=>getURL("admin?table=$name")], $title));
    }

    return tag("ul", [], $result);
}