<?php

//PŘIHLÁŠOVÁNÍ UŽIVATELE

require_once("../db/db.php");

//nastaví globální proměnnou
$userId = $_SESSION["userId"];

//načte dle id uživatele z databáze
$user = dbGetOne("vstr_users", $userId);

//pokud uživatel neexistuje přesměruje na přihlašovací obrazovku
if (!$user) {
    header('Location: '.getUrl("user"));
    die("Tato stránka je pouze pro přihlášené uživatele");
}