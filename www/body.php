<?php

function test2DrawAllFiles() {
    $files = glob("./files/*");

    $result = "";

    //první druh smyčky
    foreach ($files as $currentFileIndex=>$value) {
        $result = "<p>$currentFileIndex : $value</p>";
    }

    //druhý druh smyčky
    $filesCount = count($files);
    $currentFileIndex = 0;

    while ($currentFileIndex < $filesCount) {
        $value = $files[$currentFileIndex];
        $currentFileNumber = $currentFileIndex + 1;
        $result = $result."<p>$currentFileNumber/$filesCount : $value</p>";
        $currentFileIndex ++;
    }

    return $result;
}

//MAPA
$places = [
    "lounge"=>[
        "actions"=>[
            "openDoor",
        ],
        "objects"=>[
            "tv"
        ],
        "nextSpaces"=>[
            "street"
        ]
    ],
    "street"=>[
        "actions"=>[],
        "objects"=>[],
        "nextSpaces"=>[
            "lounge"
        ]
    ]
];

//SOUČASNÝ STAV
$currentState = isset($_GET["currentState"]) ? json_decode($_GET["currentState"], true) : [
    "place"=>"street",
    "backpack"=>[]
];

//SOUČASNÁ AKCE
if (isset($_GET["goto"])) { $currentState["place"] = $_GET["goto"]; }; 
if (isset($_GET["pickup"])) { $currentState["backpack"][] = $_GET["pickup"]; }; 


function createBody() {
    global $places;
    global $currentState;

    $currentPlaceName = $currentState["place"];
    $currentBackpack = $currentState["backpack"];

    $place = $places[$currentPlaceName];

    $result = "<h1>".$currentPlaceName."</h1>";

    $objects = $place["objects"];

    $resultBackpack = "";
    foreach ($currentBackpack as $object) {
        $resultBackpack .= "</p>$object</p>";
    }

    $resultObjects = "";
    foreach ($objects as $object) {
        $resultObjects .= "<a href='/www/index.php?currentState=".json_encode($currentState)."&pickup=$object'>Pick up $object</a>";
    }
    
    $nextSpaces = $place["nextSpaces"];
    $resultGoto = "";
    foreach ($nextSpaces as $placeName) {
        $resultGoto .= "<a href='/www/index.php?cureentState=".json_encode($currentState)."&goto=$placeName'>Go to $placeName</a>";
    }

    return "<div>$result</div><br><div><h2>Obsah batohu</h2>$resultBackpack</div><br><div><h2>Objekty k sebrání:</h2>$resultObjects</div><br><div><h2>Další místnosti</h2>$resultGoto</div>";
}



