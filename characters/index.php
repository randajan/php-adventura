<?php

//SEZNAM POSTAV, VYTVOŘENÍ NOVÉ POSTAVY

require_once("../tools/tags.php");
require_once("../tools/page.php");
require_once("../tools/components.php");

require_once("../db/db.php");
require_once("../game/user.php");


//odhlásit se z postavy, preventivně
unset($_SESSION["characterId"]);

//funkce pro vytvoření nové postavy
function createChar() {
    global $db;
    global $userId;

    if ($_SERVER["REQUEST_METHOD"] != "POST") { return; }

    $name = $db->real_escape_string($_POST["name"]);

    if (!$name) { return; }

    $char = dbGetWhere("vstr_characters", "`user`='$userId' AND `name`='$name'");

    if (strlen($name) > 16) { return "Příliš dlouhé jméno"; }
    if ($char) { return "Postava s tímto názvem již existuje"; }

    $query = dbInsert("vstr_characters", ["user"=>$userId, "name"=>$name]);
    if (!$query) { return "Postavu se nepodařilo vytvořit"; }

}

//vytvoření nové postavy (pokud to jde)
$msg = createChar();

//zísání seznamu všech postav aktuálního uživatele
$characters = dbGetAll("vstr_characters", "`user`='$userId'");

//vytvoření html seznamu postav
$chrs = "";
foreach ($characters as $character) {
    $chrs .= tag("div", ["class"=>"character"],
        tag("a", ["href"=>getUrl("game?selectCharacter=".$character["id"])], htmlspecialchars($character["name"]))
    );
}

//vygenerování html celé stránky
die(htmlPage("Postavy",
    tag("div", ["class"=>"board"], 
        (!$user["is_admin"] ? "" : href("adminedit", "admin", "Upravit nastavení"))
        .href("signout", "user", "Odhlásit se")
        .tag("div", ["class"=>"block"],
            tag("div", ["class"=>"characters"],
                tag("form", ["class"=>"add", "method"=>"post", "action"=>$_SERVER["PHP_SELF"]],
                    tag("table", [], tag("tbody", [], 
                        inputField("name", "Jméno postavy", "", true)
                    ))
                    .tag("input", ["type"=>"submit", "value"=>"Vytvořit postavu"], false, false)
                    .tag("div", ["class"=>"msg"], $msg)
                )
                .tag("div", ["class"=>"list"], $chrs)
            )
        )
    )
));