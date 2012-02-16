#Snowflake
Fast and easy-to-use minimalistic PHP web framework

Starting off
--------

Download Snowflake, create a file called index.php and put them both into a directory together.

On top of your index.php, include snowflake.php and initialize it:

`

require_once("snowflake.php");

$snowflake = new Snowflake;

`

Then, at the bottom of your file, run the application!

`

require_once("snowflake.php");

$snowflake = new Snowflake;

/* Routes here */

$snowflake->run();

`

Now it's time to create some routes!

Routing
--------
Snowflake allows you to create routes that map to (inline) functions. You can choose to route incoming requests based on their request type (GET, POST) or to implement a catch-all route that catches every request type if the route matches.

`

$snowflake->get("/", function() {
    echo "Hello world!";
});

$snowflake->post("/", function() {
    echo "Hello world!";
});

$snowflake->match("/", function() {
    echo "Hello world!";
});

`

Sometimes, you'll want to include parameters in your URLs and access them within your application. Snowflake allows for specifying those parameters in your routes.

`

$snowflake->get("/hello/:name", function($params) {
    echo "Hello " . $params['name'];
});

$snowflake->get("/ilove/:object", function($params) {
    echo "Everyone loves " . $params['object'];
});
`


Rendering templates
--------
Rendering templates is as easy as it can get thanks to Snowflakes' render() function. Let's take the "Hello" example from above:

`
$snowflake->get("/hello/:name", function($params) {
    echo "Hello " . $params['name'];
});
`

Let's move the echo part to a seperate template file.

`
<html>
    <body>
        <h2>Hello <? echo $name; ?>!</h2>
    </body>
</html>
`

`
$snowflake->get("/hello/:name", function($params) use($snowflake) {
    $snowflake->render("templates/hello.php.html", array("name" => $params['name'])); 
});
`

Notice
--------
Snowflake is in active development. Running a Snowflake-based application in a production environment is only recommended if you know what you're doing. Things change and may cause your application to break. Always double-check the changelog before you update in this early development stage. 