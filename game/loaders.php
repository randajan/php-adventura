<?php

require_once("./db/db.php");

function getScene($sceneId) {
    if (!isset($sceneId)) { return; }
    return dbGetOne("vstr_scenes", $sceneId);
}

function getStuff($stuffId) {
    if (!$stuffId) { return ""; }
    return dbGetOne("vstr_stuffs", $stuffId);
}