<?php

require_once("../components/page.php");

require_once("../db/db.php");

function createChar() {
    
}

$chrs = dbGetAll("vstr_characters");

echo(htmlPage("Postavy",
    tag("div", ["class"=>"characters"],
        tag("form", ["class"=>"add", "method"=>"post", "action"=>$_SERVER["PHP_SELF"]],
            inputField("name", "Jméno postavy", "", true)
            .tag("input", ["type"=>"submit", "value"=>"Přihlásit"], false, false)
            .tag("div", ["class"=>"msg"], createChar())
            .tag("a", ["href"=>"/www/signup.php"], "Registrovat")
        )
    )
));