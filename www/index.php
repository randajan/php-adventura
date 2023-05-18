<?php

require_once("../tools/tags.php");
require_once("../components/page.php");
require_once("../components/form.php");

echo(htmlPage("Hlavní menu",
    tag("form", ["class"=>"signin"], 
        tag("h2", [], "Přihlášení")
        .inputField("username", "Uživatel")
        .inputField("password", "Heslo")
    )
    .tag("form", ["class"=>"signup"],
        tag("h2", [], "Registrace")
        .inputField("username", "Uživatel")
        .inputField("password", "Heslo")
    )
));
