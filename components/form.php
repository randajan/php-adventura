<?php

require_once("../tools/tags.php");

function inputField($name, $title) {
  return tag("div", ["class"=>"field-$name"], 
    tag("label", ["for"=>$name], $title)
    .tag("input", ["name"=>$name], "", false)
  );
}