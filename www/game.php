<?php

require_once("../game/state.php");
require_once("../game/actions.php");
require_once("../components/page.php");
require_once("../class/Parsedown.php");
require_once("../tools/tags.php");

if (isset($_GET["scene"])) { gotoScene($_GET["scene"]); }
if (isset($_GET["stuff"])) { pickUp($_GET["stuff"]); }
if (isset($_GET["focus"])) { focusOn($_GET["focus"]); }

$scene = (new Parsedown())->text(getScene($state["scene"]));
$focus = (new Parsedown())->text(getStuff($state["focus"]));
$bag = "";

foreach ($state["bag"] as $k=>$v) {
    $bag .= tag("div", ["class"=>"stuff", "id"=>"stuff-$k"],
        tag("a", ["class"=>"title", "href"=>"?focus=$k"], $v)
    );
}

echo(htmlPage("Vyšetřovatel",
    tag("div", ["class"=>"board"], 
        tag("div", ["class"=>"block"],
            tag("div", ["class"=>"scene"], $scene)
            .tag("div", ["class"=>"focus"], $focus)
            .tag("div", ["class"=>"bag-pane"],
                tag("div", ["class"=>"block"],
                    tag("h2", "", "Batoh")
                    .tag("div", ["class"=>"bag"], 
                        $bag
                    )
                )
            )
        )
        .tag("a", ["href"=>"?reset=true"], "RESETOVAT HRU")
    )
));