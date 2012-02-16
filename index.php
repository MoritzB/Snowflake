<?php
require_once("snowflake.php");

$snowflake = new Snowflake;

$snowflake->get("_root_", function() use($snowflake) {
    $snowflake->render('templates/index.php.html', array("message" => "Hello world"));
});

$snowflake->get("/hello/:name", function($params) use($snowflake) {
    $snowflake->render("templates/hello.php.html", array("name" => $params['name'])); 
});

$snowflake->get("_404_", function() use($snowflake) {
    echo "No route found for " . $snowflake->request['path'] . " (" . $snowflake->request['method'] . ")";
});

$snowflake->run();
?>