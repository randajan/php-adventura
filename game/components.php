<?php

require_once("../tools/tags.php");
require_once("../db/db.php");
require_once("../game/character.php");

$scenes = reindexByKey(dbGetAll("vstr_scenes"));
$stuffs = reindexByKey(dbGetAll("vstr_stuffs"));

$characterStuffs = reindexByKey(dbGetAll("vstr_characters_stuffs", "`character_id`='$characterId'"), "stuff_id");


function getScene($sceneId) {
    global $scenes;
    return isset($scenes[$sceneId]) ? $scenes[$sceneId] : null;
}

function getStuff($stuffId) {
    global $stuffs;
    return isset($stuffs[$stuffId]) ? $stuffs[$stuffId] : null;
}

function hrefGoto($sceneId) {
    $scene = getScene($sceneId);
    return $scene ? tag("li", ["class"=>"goto"], tag("a", ["class"=>"title", "href"=>getURL("game?goto=$sceneId")], $scene["title"])) : "";
}

function hrefPickup($stuffId) {
    global $characterStuffs;
    if (!isset($characterStuffs[$stuffId])) { return ""; }
    $stuff = getStuff($stuffId);
    return $stuff ? tag("li", ["class"=>"pickup"], tag("a", ["class"=>"title", "href"=>getURL("game?pickup=$stuffId")], $stuff["title"])) : "";
}

function gameDesc($sceneOrStuff, $h=2) {

    if (!$sceneOrStuff) { return ""; }
    $title = $sceneOrStuff["title"];
    $description = $sceneOrStuff["description"];

    $gotos = hrefGoto($sceneOrStuff["scene_1"]).hrefGoto($sceneOrStuff["scene_2"]);
    $pickups = hrefPickup($sceneOrStuff["stuff_1"]).hrefPickup($sceneOrStuff["stuff_2"]);
    
    return tag("div", ["class"=>"gamedesc"], 
        tag("h$h", [], $title)
        .tag("div", ["class"=>"description"], $description)
        .(!$gotos ? "" : tag("div", ["class"=>"gotos"],
            tag("h".($h+1), [], "Nová místa")
            .tag("ul", ["class"=>"content"], $gotos)
        ))
        .(!$pickups ? "" : tag("div", ["class"=>"gotos"],
            tag("h".($h+1), [], "Věci k sebrání")
            .tag("ul", ["class"=>"content"], $pickups)
        ))
    );
}

function gameCharStuffs() {
  global $characterStuffs;

  $result = "";

  foreach ($characterStuffs as $id=>$chstuff) {
      $stuff = getStuff($id);
      $result .= tag("li", ["class"=>"stuff", "id"=>"stuff-$id"],
          tag("a", ["class"=>"title", "href"=>"?focus=$id"], $stuff["title"])
      );
  }

  return tag("div", ["class"=>"charstuffs"], 
    tag("h3", [], "Batoh")
    .tag("ul", ["class"=>"content"], $result)
  );
}

function gameCharScenes() {
    global $characterId;
    global $character;
    $result = "";
  
    $chscenes = dbGetAll("vstr_characters_scenes", "`character_id`='$characterId'");
    
    foreach ($chscenes as $chscene) {
        $id = $chscene["scene_id"];
        $scene = getScene($id);
        $tagname = $id === $character["scene"] ? "span" : "a";

        $result .= tag("li", ["class"=>"scene", "id"=>"scene-$id"],
            tag($tagname, ["class"=>"title", "href"=>"?goto=$id"], $scene["title"])
        );
    }
  
    return tag("div", ["class"=>"charscenes"],
      tag("h3", [], "Známá místa")
      .tag("ul", ["class"=>"content"], $result)
    );
}