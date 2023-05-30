<?php

require_once("./tools/tags.php");

function inputField($name, $title, $type="", $required=false) {

  $atr = ["name"=>$name];
  if ($type) { $atr["type"] = $type; }
  if ($required) { $atr["required"] = ""; }

  return tag("div", ["class"=>"field-$name"], 
    tag("label", ["for"=>$name], $title)
    .tag("input", $atr, "", false)
  );
}