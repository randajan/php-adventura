<?php

require("../tools/tags.php");
require("../components/page.php");

echo(htmlPage("Administrace", 
    tag("form", ["class"=>"signin"], 
        tag("h2", "Přihlášení")
        .tag("input", ["name"=>"username"], "", false)
        .tag("input", ["name"=>"password"], "", false)
    )
    .tag("form", ["class"=>"signup"],
        tag("h2", "Registrace")
        .tag("input", ["name"=>"username"], "", false)
        .tag("input", ["name"=>"password"], "", false)
    )




));