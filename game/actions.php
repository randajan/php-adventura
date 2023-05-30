<?php

require_once("../db/db.php");

function gotoScene($sceneId) {
    global $state;
    $state["focus"] = "";
    $state["scene"] = $sceneId;
}

function pickUp($stuffId) {
    global $state;

    $stuff = dbGetOne("vstr_stuffs", $stuffId);
    $state["bag"][$stuffId] = $stuff["title"];
}

function focusOn($stuffId) {
    global $state;
    $state["focus"] = $stuffId;
}
