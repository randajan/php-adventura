<?php

function gotoScene($sceneId) {
    global $state;
    $state["focus"] = "";
    $state["scene"] = $sceneId;
}

function pickUp($stuffId) {
    global $state;
    //$stuff = file_get_contents("../db/stuff/$stuffId.md");

    $state["bag"][$stuffId] = $stuffId;
}

function focusOn($stuffId) {
    global $state;
    $state["focus"] = $stuffId;
}

function getScene($sceneId) {
    if (!isset($sceneId)) { return ""; }
    return file_get_contents("../db/scenes/$sceneId.md");
}

function getStuff($stuffId) {
    if (!$stuffId) { return ""; }
    return file_get_contents("../db/stuff/$stuffId.md");
}
