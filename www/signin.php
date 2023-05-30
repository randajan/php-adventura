<?php


require_once("../tools/tags.php");
require_once("../components/page.php");
require_once("../components/form.php");

require_once("../db/db.php");

function signIn() {
    global $db;

    if ($_SERVER["REQUEST_METHOD"] != "POST") { return; }

    $username = $db->real_escape_string($_POST["username"]);
    $password = $db->real_escape_string($_POST["password"]);

    if (!$username || !$password) { return; }

    $user = dbGetWhere("vstr_users", "`username`='$username'");

    if (!$user) { return "Uživatel '$username' neexistuje"; }

    $result = password_verify($password, $user["password"]);
    
    if ($result) {
        $_SESSION["user"] = $user["id"];
        header('Location: /www/user.php');
        return "OK";
    } else {
        return "Špatné heslo";
    }

}

echo(htmlPage("Přihlášení",
    tag("form", ["class"=>"signin", "method"=>"post", "action"=>$_SERVER["PHP_SELF"]],
        inputField("username", "Uživatel", "", true)
        .inputField("password", "Heslo", "password", true)
        .tag("input", ["type"=>"submit", "value"=>"Přihlásit"], false, false)
        .tag("div", ["class"=>"msg"], signIn())
        .tag("a", ["href"=>"/www/signup.php"], "Registrovat")
    )
));