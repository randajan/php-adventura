<?php

require_once("../db/db.php");

if (isset($_SESSION["characterId"])) {
    header('Location: /www/game.php');
    die();
}

if (isset($_SESSION["userId"])) {
    header('Location: /www/characters.php');
    die();
}


header('Location: /www/signin.php');

