<?php


require_once("../tools/tags.php");
require_once("../tools/page.php");
require_once("../tools/components.php");

require_once("../db/db.php");

function signUp() {
    global $db;

    if ($_SERVER["REQUEST_METHOD"] != "POST") { return; }

    $username = $db->real_escape_string($_POST["username"]);
    $password = $db->real_escape_string($_POST["password"]);
    $password_confirm = $db->real_escape_string($_POST["password_confirm"]);

    if (!$username || !$password || !$password_confirm) { return; }

    if ($password !== $password_confirm) { return "Hesla se neshodují"; }

    if (strlen($username) > 16) { return "Příliš dlouhé uživatelské jméno"; }
    if (strlen($password) > 16) { return "Příliš dlouhé heslo"; }
    if (dbGetWhere("vstr_users", "`username`='$username'")) { return "Uživatelské jméno je obsazeno"; }

    $hash = password_hash($password, PASSWORD_DEFAULT);

    $query = dbInsert("vstr_users", ["username"=>$username, "password"=>$hash]);
    if (!$query) { return "Chyba při registraci"; }

    $user = dbGetWhere("vstr_users", "`username`='$username'");
    if (!$user) { return "Chyba při registraci"; }

    $_SESSION["userId"] = $user["id"];
    header('Location: '.getUrl("characters"));
    die();

}

echo(htmlPage("Registrace",
    tag("div", ["class"=>"board"], 
        tag("div", ["class"=>"block"],
            tag("form", ["class"=>"signup", "method"=>"post", "action"=>$_SERVER["PHP_SELF"]],
                inputField("username", "Uživatel", "", true)
                .inputField("password", "Heslo", "password", true)
                .inputField("password_confirm", "Potvrzení hesla", "password", true)
                .tag("input", ["type"=>"submit", "value"=>"Registrovat"], false, false)
                .tag("div", ["class"=>"msg"], signUp())
            )
        )
    )
));