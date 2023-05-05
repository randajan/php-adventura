<?php

require_once("./tables.php");

function createHTMLHead($title) {
    return "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <meta http-equiv='X-UA-Compatible' content='ie=edge'>
        <title>$title</title>
        <link rel='stylesheet' href='./style.css'>
        <link rel='icon' href='./favicon.ico' type='image/x-icon'>
    </head><body>";
};

function createHTMLFoot() {
    return "
    <p>Zápatí každé stránky</p>
    </body>
    </html>
    ";
};

function createTemplate($title, $next) {

    return createHTMLHead($title)."
        <main>
            <h1>Welcome to My Website $title</h1>
            <a href='/www/$next.php'>$next</a>
            ".createList(["Chleba", "Mlíko", "Rohlíky"])."
        </main>
    ".createHTMLFoot();
};

?>