<?php

require_once("./game/character.php");

function pushState() {
    global $db;
    global $userId;
    global $characterId;
    global $state;
    $blob = $db->real_escape_string(json_encode($state));
    $db->query("UPDATE `vstr_characters` SET `state`= '$blob' WHERE `user`='$userId' AND `id`='$characterId'");
}

function gotoScene($sceneId) {
    global $state;
    $state["focus"] = "";
    $state["scene"] = $sceneId;
    pushState();
}

function pickUp($stuffId) {
    global $state;

    $stuff = dbGetOne("vstr_stuffs", $stuffId);
    $state["bag"][$stuffId] = $stuff["title"];
    pushState();
}

function focusOn($stuffId) {
    global $state;
    $state["focus"] = $stuffId;
    pushState();
}
