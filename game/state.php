<?php

require_once("../db/db.php");

if (isset($_GET["reset"])) { unset($_SESSION["state"]); }

if (!isset($_SESSION["state"]) || !$_SESSION["state"]) {
    $sceneStart = dbGetWhere("vstr_scenes", "`is_start`=1");
    $_SESSION["state"] = [
        "scene"=>$sceneStart["id"],
        "focus"=>"",
        "bag"=>[]
    ];
}


$state = &$_SESSION["state"];