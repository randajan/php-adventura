<?php

require_once("../game/character.php");
require_once("../game/actions.php");
require_once("../tools/components.php");
require_once("../tools/page.php");
require_once("../tools/tags.php");

if (!$character["scene"]) {
    $startScene = dbGetWhere("vstr_scenes", "`is_start`=1");
    gotoScene($startScene["id"]);
}

if (isset($_GET["goto"])) { gotoScene($_GET["goto"]); }
if (isset($_GET["pickup"])) { pickUp($_GET["pickup"]); }
if (isset($_GET["focus"])) { focusOn($_GET["focus"]); }

require_once("../game/components.php");

$scene = getScene($character["scene"]);
$focus = getStuff($character["focus"]);

die(htmlPage("Vyšetřovatel - ".$character["name"],
    tag("div", ["class"=>"board"], 
        href("changechar", "characters", "Změnit postavu")
        .tag("div", ["class"=>"block"],
            gameDesc($scene, 2)
            .tag("div", ["class"=>"flex"], 
                gameCharStuffs().gameCharScenes()
            )
            .gameDesc($focus, 3)
            
        )
    )
));