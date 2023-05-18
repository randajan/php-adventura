<?php

require_once("../game/state.php");
require_once("../game/loader.php");
require_once("../components/page.php");
require_once("../class/Parsedown.php");
require_once("../tools/tags.php");

$scene = (new Parsedown())->text(getScene($state["scene"]));
$bag = "";

foreach ($state["bag"] as $k=>$v) {
    $bag .= tag("div", ["class"=>"stuff", "id"=>"stuff-$k"],
        tag("span", ["class"=>"title"], $v)
    );
}

echo(htmlPage("Vyšetřovatel",
    tag("div", ["class"=>"board"], 
        tag("div", ["class"=>"block"],
            tag("div", ["class"=>"scene"], $scene)
            .tag("div", ["class"=>"bag-pane"],
                tag("div", ["class"=>"block"], 
                    tag("div", ["class"=>"bag"], 
                        $bag
                    )
                )
            )
        )
    )
));