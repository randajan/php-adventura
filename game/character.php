<?php

require_once("./game/user.php");



if (isset($_GET["selectCharacter"])) {
    $_SESSION["characterId"] = $_GET["selectCharacter"];
}

$characterId = $_SESSION["characterId"];

$character = dbGetWhere("vstr_characters", "`user`='$userId' AND `id`='$characterId'");

if (!$character) {
    header('Location: /characters.php');
    die("Tato stránka je k dispozici pouze s vytvořenou postavou");
}

$state = json_decode($character["state"], true);