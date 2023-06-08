<?php

require_once("../game/character.php");

function gotoScene($sceneId) {
    global $character;
    global $characterId;
    if (!dbUpdate("vstr_characters", $characterId, ["scene"=>$sceneId, "focus"=>null])) { return false; }
    if (!dbGetWhere("vstr_characters_scenes", "`character_id`='$characterId' AND `scene_id`='$sceneId'", true)) {
        dbInsert("vstr_characters_scenes", ["character_id"=>$characterId, "scene_id"=>$sceneId]);
    }
    $character["scene"] = $sceneId;
    $character["focus"] = null;
    return true;
}

function focusOn($stuffId) {
    global $character;
    global $characterId;
    if (!dbUpdate("vstr_characters", $characterId, ["focus"=>$stuffId])) { return false; }
    $character["focus"] = $stuffId;
    return true;
}

function pickUp($stuffId) {
    global $characterId;
    if (dbGetWhere("vstr_characters_stuffs", "`character_id`='$characterId' AND `stuff_id`='$stuffId'", true)) { return false; }
    if (!dbInsert("vstr_characters_stuffs", ["character_id"=>$characterId, "stuff_id"=>$stuffId])) { return false; }
    return true;
}
