<?php

require_once("../tools/tags.php");
require_once("../tools/page.php");
require_once("../tools/components.php");

require_once("../db/db.php");
require_once("../admin/controls.php");

//important
require_once("../admin/firewall.php");

if (!isset($_GET["table"])) {
    die(htmlPage("Admin",
        tag("div", ["class"=>"board"], 
            href("back", "", "Zpět do hry")
            .adminList()
        )
    ));
}

$tableName = $_GET["table"];
$tableColumns = dbGetColumnsWithFK($tableName); // Vezme všechny sloupce tabulky

function fetchPostData($isUpdate=true) {
    global $tableColumns;

    $data = [];
    foreach ($tableColumns as $column) {
        $columnName = $column["Field"];
        $allowNull = $column['Null'] === 'YES';
        if ($columnName === "id" && ($isUpdate || $column["AutoIncrement"])) { continue; }
        $value = $_POST[$columnName];
        $data[$columnName] = (!$value && $allowNull) ? NULL : $value;
    }
    return $data;
}

$action = isset($_POST["action"]) ? $_POST["action"] : "";

if ($action === "update") {
    dbUpdate($tableName, $_POST["id"], fetchPostData(true));
}
else if ($action === "insert") {
    dbInsert($tableName, fetchPostData(false));
}
else if ($action === "delete") {
    dbDelete($tableName, $_POST["id"]);
}

die(htmlPage("Admin - ".dbGetTitle($tableName),
    tag("div", ["class"=>"board"], 
        href("back", "admin", "Zpět na seznam")
        .adminTable($tableName, $tableColumns, dbGetAll($tableName))
    )
));