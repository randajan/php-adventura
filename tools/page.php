<?php

require_once("../db/db.php");

function htmlPage($title, $body) {

return '
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>'.$title.'</title>
    <link rel="stylesheet" href="'.getURL("styles.css?v=3").'">
    <link rel="icon" href="'.getURL("favicon.ico?v=3").'" type="image/x-icon">
  </head>
  <body>
    <h1>'.$title.'</h1>
    '.$body.'
  </body>
</html>
';

}

