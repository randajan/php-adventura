<?php

require_once("./tools/tags.php");
require_once("./tools/page.php");
require_once("./tools/form.php");

require_once("./db/db.php");
require_once("./game/user.php");

function adminInput($column, $value) {
    $columnName = $column['Field'];
    $columnType = $column["Type"];

    $attr = [
        "type"=>"text",
        "name"=>$columnName,
        "value"=>$value,
        "class"=>"dbfield",
        "size"=>$column["Length"],
        "data-dbtype"=>$columnType
    ];

    if ($columnName === "id") { $attr["readonly"] = ""; }

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

    $attr = [
        "name" => $columnName,
        "class" => "dbfield",
        "rows" => "5",  // Nastavení počtu řádků
        "cols" => $column["Length"],
        "data-dbtype" => $columnType
    ];

    if ($columnName === "id") { $attr["readonly"] = ""; }

    return tag("textarea", $attr, $value);
}

function adminRow($table, $columns, $row, $foreignData=[]) {
    $result = "";
    foreach ($columns as $column) {
        $value = $row[$column["Field"]];
        $type = $column["Type"];
        $cfk = $column["ForeignKey"];

        if ($cfk) { $field = adminSelect($column, $value, $foreignData[$cfk]); }
        else if ($type === "longtext") { $field = adminTextarea($column, $value); }
        else { $field = adminInput($column, $value); }
        
        $result .= tag("td", [], $field);
    }
    $result .= tag("td", [], tag("input", ["type"=>"submit", "value"=>"Update"], "", false));
    
    return tag("form", ["method"=>"POST", "action"=>"/admin.php?table=$table"], tag("tr", [], $result));
}


function adminTable($table, $columns, $rows) {

     // Generuje hlavičku tabulky
    $thead = "";
    $foreignData = [];
    foreach ($columns as $column) {
        $cfk = $column["ForeignKey"];
        if ($cfk && !$foreignData[$cfk]) {
            $foreignData[$cfk] = dbGetAllIdOnly($cfk);
        }
        $thead .= tag("th", "", $column['Field']);
    }

    // Generuje tělo tabulky
    $tbody = "";
    foreach ($rows as $row) { $tbody .= adminRow($table, $columns, $row, $foreignData); }

    return tag("table", [], tag("thead", [], $thead).tag("tbody", [], $tbody));
}
