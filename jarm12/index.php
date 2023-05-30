<?php

require_once("./db/db.php");

if (isset($_SESSION["characterId"])) {
    header('Location: '.getUrl("game.php"));
    die();
}

if (isset($_SESSION["userId"])) {
    header('Location: '.getUrl("characters.php"));
    die();
}


header('Location: '.getUrl("signin.php"));

