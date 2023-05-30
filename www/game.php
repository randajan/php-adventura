<?php

require_once("../game/character.php");
require_once("../game/actions.php");
require_once("../game/loaders.php");
require_once("../components/page.php");
require_once("../tools/Parsedown.php");
require_once("../tools/tags.php");

if (isset($_GET["scene"])) { gotoScene($_GET["scene"]); }
if (isset($_GET["stuff"])) { pickUp($_GET["stuff"]); }
if (isset($_GET["focus"])) { focusOn($_GET["focus"]); }

$scene = getScene($state["scene"]);
$focus = getStuff($state["focus"]);
$bag = "";

foreach ($state["bag"] as $k=>$v) {
    $bag .= tag("div", ["class"=>"stuff", "id"=>"stuff-$k"],
        tag("a", ["class"=>"title", "href"=>"?focus=$k"], $v)
    );
}

function desc($sceneOrStuff) {
    if (!$sceneOrStuff) { return ""; }
    $title = $sceneOrStuff["title"];
    $description = $sceneOrStuff["description"];
   
    return tag("div", ["class"=>"scene"], 
        tag("h1", [], $title)
        .tag("div", ["class"=>"description"], (new Parsedown())->text($description))
    );
}

echo(htmlPage("Vyšetřovatel",
    tag("div", ["class"=>"board"], 
        tag("div", ["class"=>"block"],
            desc($scene)
            .desc($focus)
            .tag("div", ["class"=>"bag-pane"],
                tag("div", ["class"=>"block"],
                    tag("h2", [], "Batoh")
                    .tag("div", ["class"=>"bag"], 
                        $bag
                    )
                )
            )
            .tag("a", ["href"=>"/www/characters.php"], "Změnit postavu")
        )
    )
));