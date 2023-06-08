<?php

//HERNÍ STRÁNKA

require_once("../game/character.php");
require_once("../game/actions.php");
require_once("../tools/components.php");
require_once("../tools/page.php");
require_once("../tools/tags.php");


//pokud postava není v žádné místnosti tak přiřadí první výchozí místnost
if (!$character["scene"]) {
    $startScene = dbGetWhere("vstr_scenes", "`is_start`=1");
    gotoScene($startScene["id"]);
}

//tři různé možné akce, změna místnosti, sebrání a změna zaměření na předmět
if (isset($_GET["goto"])) { gotoScene($_GET["goto"]); }
if (isset($_GET["pickup"])) { pickUp($_GET["pickup"]); }
if (isset($_GET["focus"])) { focusOn($_GET["focus"]); }

//sbírá infromace o místech, věcech a věcech uživatele z databáze
require_once("../game/components.php");

//zjistí místo a zaměření na předmět
$scene = getScene($character["scene"]);
$focus = getStuff($character["focus"]);

//generuje html herní stránky
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