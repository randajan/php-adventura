<?php

require_once("../tools/tags.php");
require_once("../tools/page.php");
require_once("../tools/components.php");

require_once("../db/db.php");
require_once("../game/user.php");



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

    if ($columnName === "id") { $attr["required"] = ""; }
    if ($columnName === "id" && ($value || $columnAI)) { $attr["readonly"] = ""; }

    return tag("input", $attr, "", false);
}

function adminSelect($column, $value, $options) {
    $columnName = $column['Field'];
    $allowNull = $column['Null'] === 'YES';

    $attr = [
        "name" => $columnName,
        "class" => "dbfield",
    ];

    $optionTags = "";
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

function adminRow($table, $columns, $row=null, $foreignData=[]) {
    $result = "";
    
    foreach ($columns as $column) {
        $value = $row ? $row[$column["Field"]] : "";
        $type = $column["Type"];
        $cfk = $column["ForeignKey"];

        if ($cfk) { $field = adminSelect($column, $value, $foreignData[$cfk]); }
        else if ($type === "longtext" || $type === "text") { $field = adminTextarea($column, $value); }
        else { $field = adminInput($column, $value); }
        
        $result .= tag("td", [], $field);
    }

    $buttonValue = $row ? "update" : "insert";
    $result .= tag("td", [], tag("input", ["type"=>"submit", "name"=>"action", "value"=>$buttonValue], "", false));
    if ($row) { $result .= tag("td", [], tag("input", [
        "type"=>"submit", "name"=>"action", "value"=>"delete",
        "onclick" => "return confirm('Opravdu smazat?');"
    ], "", false)); }

    return tag("form", ["method"=>"POST", "action"=>getURL("admin/?table=$table")], tag("tr", [], $result));
}


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

    // Generuje tělo tabulky
    $tbody = "";
    foreach ($rows as $row) { $tbody .= adminRow($table, $columns, $row, $foreignData); }

    $tbody .= adminRow($table, $columns, null, $foreignData);

    return tag("table", [], tag("thead", [], $thead).tag("tbody", [], $tbody));
}


function adminList() {
    global $DBtables;

    $result = "";
    foreach($DBtables as $name=>$title) {
        $result .= tag("li", [], tag("a", ["href"=>getURL("admin?table=$name")], $title));
    }

    return tag("ul", [], $result);
}