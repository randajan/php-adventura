<?php

//ZÁKLADNÍ PŘESMĚROVÁNÍ

//Pokud existuje v session přihlášená postava tak přesměruje na hru

//Načtení souboru s informacemi o databázi a začátek session
require_once("./db/db.php");

//Pokud existuje v session přihlášená postava tak přesměruje na hru
if (isset($_SESSION["characterId"])) {
    header('Location: '.getUrl("game"));
    die();
}

//Pokud existuje v session přihlášený uživatel tak přesměruje na seznam postav
if (isset($_SESSION["userId"])) {
    header('Location: '.getUrl("characters"));
    die();
}

//Pokud není ani přihlášení uživatel tak přesměruje na přihlašovací stránku
header('Location: '.getUrl("user"));

