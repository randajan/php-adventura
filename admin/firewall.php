<?php

#HLÍDA ZDA JE UŽIVATEL ADMIN

require_once("../game/user.php");

//odlhášení postavy
unset($_SESSION["characterId"]);

//pokud není admin přesměruje pryč
if (!$user["is_admin"]) {
    header('Location: '.getUrl(""));
    die("Tato stránka je pouze pro adminy");
}