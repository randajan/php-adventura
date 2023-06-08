<?php

require_once("./db/db.php");

if (isset($_SESSION["characterId"])) {
    header('Location: '.getUrl("game"));
    die();
}

if (isset($_SESSION["userId"])) {
    header('Location: '.getUrl("characters"));
    die();
}


header('Location: '.getUrl("user"));

