<?php

session_start();

if (!isset($_SESSION["state"])) {
    $_SESSION["state"] = [
        "scene"=>"office",
        "bag"=>["gun"=>"Pistole"]
    ];
}


$state = $_SESSION["state"];