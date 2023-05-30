<?php

require_once("./db/db.php");

if (isset($_SESSION["characterId"])) {
    header('Location: /game.php');
    die();
}

if (isset($_SESSION["userId"])) {
    header('Location: /characters.php');
    die();
}


header('Location: /signin.php');

