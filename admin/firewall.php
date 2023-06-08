<?php


require_once("../game/user.php");

//logout character
unset($_SESSION["characterId"]);

//admins only
if (!$user["is_admin"]) {
    header('Location: '.getUrl(""));
    die("Tato stránka je pouze pro adminy");
}