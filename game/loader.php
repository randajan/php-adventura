<?php

function getScene($name) {
    return file_get_contents("../db/scenes/$name.md");
}