<?php


require_once("./tools/tags.php");
require_once("./tools/page.php");
require_once("./tools/form.php");

require_once("./db/db.php");

function signUp() {
    global $db;

    if ($_SERVER["REQUEST_METHOD"] != "POST") { return; }

    $username = $db->real_escape_string($_POST["username"]);
    $password = $db->real_escape_string($_POST["password"]);

    if (!$username || !$password) { return; }

    if (strlen($username) > 16) { return "Příliš dlouhé uživatelské jméno"; }
    if (strlen($password) > 16) { return "Příliš dlouhé heslo"; }
    if (dbGetWhere("vstr_users", "`username`='$username'")) { return "Uživatelské jméno je obsazeno"; }

    $hash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO vstr_users (username, password) VALUES ('$username', '$hash')";
    if ($db->query($sql) !== TRUE) { return "Chyba při registraci"; }

    $user = dbGetWhere("vstr_users", "`username`='$username'");
    if (!$user) { return "Chyba při registraci"; }

    $_SESSION["userId"] = $user["id"];
    header('Location: '.getUrl("characters.php"));
    die();

}

echo(htmlPage("Registrace",
    tag("div", ["class"=>"board"], 
        tag("div", ["class"=>"block"],
            tag("form", ["class"=>"signup", "method"=>"post", "action"=>$_SERVER["PHP_SELF"]],
                inputField("username", "Uživatel", "", true)
                .inputField("password", "Heslo", "password", true)
                .tag("input", ["type"=>"submit", "value"=>"Registrovat"], false, false)
                .tag("div", ["class"=>"msg"], signUp())
            )
        )
    )
));