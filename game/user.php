<?php

require_once("../db/db.php");

$userId = $_SESSION["userId"];

$user = dbGetOne("vstr_users", $userId);

if (!$user) {
    //header('Location: /www/signin.php');
    die("Tato stránka je pouze pro přihlášené uživatele");
}