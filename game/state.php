<?php

session_start();
//session_unset();

if (!isset($_SESSION["state"])) {
    $_SESSION["state"] = [
        "scene"=>"office",
        "focus"=>"",
        "bag"=>[]
    ];
}


$state = $_SESSION["state"];