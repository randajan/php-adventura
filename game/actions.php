<?php

//DEFINICE AKCÍ, KTERÉ MŮŽE POSTAVA SPÁCHAT

require_once("../game/character.php");

//přechod na jiné místo
function gotoScene($sceneId) {
    global $character;
    global $characterId;
    if (!dbUpdate("vstr_characters", $characterId, ["scene"=>$sceneId, "focus"=>null])) { return false; }

    //pokud postava přichází na úplně nové místo, přidá se do seznamu "známých míst"
    if (!dbGetWhere("vstr_characters_scenes", "`character_id`='$characterId' AND `scene_id`='$sceneId'", true)) {
        dbInsert("vstr_characters_scenes", ["character_id"=>$characterId, "scene_id"=>$sceneId]);
    }

    $character["scene"] = $sceneId;
    $character["focus"] = null;
    return true;
}

//změna zaměření na předmět
function focusOn($stuffId) {
    global $character;
    global $characterId;
    if (!dbUpdate("vstr_characters", $characterId, ["focus"=>$stuffId])) { return false; }
    $character["focus"] = $stuffId;
    return true;
}

//zvednutí předmětu
function pickUp($stuffId) {
    global $characterId;

    //pokud předmět už hráč sebral, nejde sebrat znovu
    if (dbGetWhere("vstr_characters_stuffs", "`character_id`='$characterId' AND `stuff_id`='$stuffId'", true)) { return false; }
    
    if (!dbInsert("vstr_characters_stuffs", ["character_id"=>$characterId, "stuff_id"=>$stuffId])) { return false; }
    return true;
}
