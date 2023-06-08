<?php

//PŘIHLÁŠOVÁNÍ POSTAVY

require_once("../game/user.php");

//pokud je vybraná postava přihlásí ji
if (isset($_GET["selectCharacter"])) {
    $_SESSION["characterId"] = $_GET["selectCharacter"];
}

//načte id postavy ze session a nastaví globální proměnnou
$characterId = $_SESSION["characterId"];

//načte dle id postavu z databáze
$character = dbGetWhere("vstr_characters", "`user`='$userId' AND `id`='$characterId'");

//pokud postava v databázi dle id neexistuje tak přesměruje na stránku s výběrem postavy
if (!$character) {
    header('Location: '.getUrl("characters"));
    die("Tato stránka je k dispozici pouze s vytvořenou postavou");
}