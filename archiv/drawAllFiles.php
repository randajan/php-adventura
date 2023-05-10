<?php

function test2DrawAllFiles() {
    $files = glob("./testFilesCSV/*");

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