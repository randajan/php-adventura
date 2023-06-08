<?php

//KOMPONENTY POUŽITÉ NA HERNÍ OBRAZOVCE

require_once("../tools/tags.php");
require_once("../db/db.php");
require_once("../game/character.php");

//sesbírá z databáze seznam všech míst, předmětů a předmětů uživatele
$scenes = reindexByKey(dbGetAll("vstr_scenes"));
$stuffs = reindexByKey(dbGetAll("vstr_stuffs"));

$characterStuffs = reindexByKey(dbGetAll("vstr_characters_stuffs", "`character_id`='$characterId'"), "stuff_id");

//vrátí scénu dle jejího id
function getScene($sceneId) {
    global $scenes;
    return isset($scenes[$sceneId]) ? $scenes[$sceneId] : null;
}

//vrátí věc dle jejího id
function getStuff($stuffId) {
    global $stuffs;
    return isset($stuffs[$stuffId]) ? $stuffs[$stuffId] : null;
}

//vytvoří html odkaz na přesun do jiné místnosti
function hrefGoto($sceneId) {
    $scene = getScene($sceneId);
    return $scene ? tag("li", ["class"=>"goto"], tag("a", ["class"=>"title", "href"=>getURL("game/?goto=$sceneId")], htmlspecialchars($scene["title"]))) : "";
}

//vytvoří html odkaz na sebrání věci
function hrefPickup($stuffId) {
    global $characterStuffs;
    if (isset($characterStuffs[$stuffId])) { return ""; }
    $stuff = getStuff($stuffId);
    return $stuff ? tag("li", ["class"=>"pickup"], tag("a", ["class"=>"title", "href"=>getURL("game/?pickup=$stuffId")], htmlspecialchars($stuff["title"]))) : "";
}

//vytváří html pro zobrazení scény nebo předmětu na který má hráč zaměření, parametr $h určuje o jakou úroveň nadpisu v html se jedná (h1,h2,h3,h4)
function gameDesc($sceneOrStuff, $h=2) {

    if (!$sceneOrStuff) { return ""; }
    $title = $sceneOrStuff["title"];
    $description = $sceneOrStuff["description"];

    //sesbírá možnosti - nová místa
    $gotos = hrefGoto($sceneOrStuff["scene_1"]).hrefGoto($sceneOrStuff["scene_2"]);

    //sesbírá možnosti - věci k sebrání
    $pickups = hrefPickup($sceneOrStuff["stuff_1"]).hrefPickup($sceneOrStuff["stuff_2"]);
    
    return tag("div", ["class"=>"gamedesc"], 
        tag("h$h", [], htmlspecialchars($title))
        .tag("div", ["class"=>"description"], htmlspecialchars($description))
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

//vytváří html pro "batoh" postavy
function gameCharStuffs() {
  global $characterStuffs;

  $result = "";

  foreach ($characterStuffs as $id=>$chstuff) {
      $stuff = getStuff($id);
      $result .= tag("li", ["class"=>"stuff", "id"=>"stuff-$id"],
          tag("a", ["class"=>"title", "href"=>"?focus=$id"], htmlspecialchars($stuff["title"]))
      );
  }

  return tag("div", ["class"=>"charstuffs"], 
    tag("h3", [], "Batoh")
    .tag("ul", ["class"=>"content"], $result)
  );
}

//vytváří html pro "známá místa" postavy
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
            tag($tagname, ["class"=>"title", "href"=>"?goto=$id"], htmlspecialchars($scene["title"]))
        );
    }
  
    return tag("div", ["class"=>"charscenes"],
      tag("h3", [], "Známá místa")
      .tag("ul", ["class"=>"content"], $result)
    );
}