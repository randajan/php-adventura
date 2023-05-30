<?php

session_start();
if (isset($_GET["reset"])) { session_unset(); }

if (!isset($_SESSION["state"])) {
    $_SESSION["state"] = [
        "scene"=>"office",
        "focus"=>"",
        "bag"=>[]
    ];
}


$state = &$_SESSION["state"];