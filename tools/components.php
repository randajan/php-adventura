<?php

//JEDNODUCHÉ UNIVERZÁLNÍ KOMPONENTY

require_once("../tools/tags.php");

//vytváří políčko ve formuláři
function inputField($name, $title, $type="", $required=false) {

  $atr = ["name"=>$name];
  if ($type) { $atr["type"] = $type; }
  if ($required) { $atr["required"] = ""; }

  return tag("tr", ["class"=>"field $name"],
    tag("td", [], tag("label", ["for"=>$name], $title))
    .tag("td", [], tag("input", $atr, "", false))
  );
}

//vytváří odkaz
function href($cn, $page, $title) {
  return tag("div", ["class"=>$cn], tag("a", ["href"=>getURL($page)], $title));
}