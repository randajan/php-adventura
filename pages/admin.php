<?php

require("../tools/tags.php");
require("../components/page.php");

echo(htmlPage("Administrace", 
    tag("form", ["class"=>"signin"], 
        tag("input", ["name"=>"username"], "", false, true)
    )

    

));