<?php


require_once("../tools/tags.php");
require_once("../tools/page.php");
require_once("../tools/components.php");

require_once("../db/db.php");

unset($_SESSION["userId"]);
unset($_SESSION["characterId"]);

function signIn() {
    global $db;

    if ($_SERVER["REQUEST_METHOD"] != "POST") { return; }

    $username = $db->real_escape_string($_POST["username"]);
    $password = $db->real_escape_string($_POST["password"]);

    if (!$username || !$password) { return; }

    $user = dbGetWhere("vstr_users", "`username`='$username'");

    if (!$user) { return "Uživatel '$username' neexistuje"; }

    $result = password_verify($password, $user["password"]);

    if (!$result) { return "Špatné heslo"; }
    
    $_SESSION["userId"] = $user["id"];
    header('Location: '.getUrl("characters"));
    die();

}

echo(htmlPage("Přihlášení",
    tag("div", ["class"=>"board"], 
        href("signup", "user/signup.php", "Registrovat")
        .tag("div", ["class"=>"block"],
            tag("form", ["class"=>"signin", "method"=>"post", "action"=>$_SERVER["PHP_SELF"]],
                tag("table", [], tag("tbody", [], 
                    inputField("username", "Uživatel", "", true)
                    .inputField("password", "Heslo", "password", true)
                ))
                .tag("input", ["type"=>"submit", "value"=>"Přihlásit"], false, false)
                .tag("div", ["class"=>"msg"], signIn())
            )
        )
    )
));