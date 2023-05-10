<?php 
//vysvětlení JSON

//DEFINICE - !NEVYKONAVA SE!

function echoTableCell($columnName, $columnValue) {
    echo("<td>$columnName:$columnValue</td>");
}

function echoTableRow($row) {
    echo("<tr>");
    foreach ($row as $column=>$value) {
        echoTableCell($column, $value);
    }
    echo("</tr>");
}

function echoTable($rows) {
    echo("<table><tbody>");
    foreach ($rows as $row) {
        echoTableRow($row);
    }
    echo("</tbody></table>");
}

$rows = [
    ["a"=>1, "b"=>2, "c"=>3],
    ["a"=>4, "b"=>5, "c"=>6]
];

echoTable($rows);

//VYKONAVA SE OKAMZITE

