<?php

require_once("./tools/tags.php");
require_once("./tools/page.php");
require_once("./tools/form.php");

require_once("./db/db.php");
require_once("./game/user.php");
require_once("./game/admin.php");

//admins only
if (!$user["is_admin"]) {
    header('Location: '.getUrl("index.php"));
    die("Tato stránka je pouze pro adminy");
}

//logout character
unset($_SESSION["characterId"]);

$tableName = $_GET["table"];
$tableColumns = dbGetColumnsWithFK($tableName); // Vezme všechny sloupce tabulky

$rowId = $_POST["id"];

if ($rowId) {
    $rowData = [];
    foreach ($tableColumns as $column) {
        $columnName = $column["Field"];
        $allowNull = $column['Null'] === 'YES';
        if ($columnName === "id") { continue; }
        $value = $_POST[$columnName];
        $rowData[$columnName] = (!$value && $allowNull) ? NULL : $value;
    }
    dbUpdate($tableName, $rowId, $rowData);
}

echo(htmlPage("Postavy",
    tag("div", ["class"=>"board"], 
        adminTable($tableName, $tableColumns, dbGetAll($tableName))
    )
));