<?php 
/*require_once 'functions.php';*/
// require_once __DIR__ . '/Users.php';
/*require_once __DIR__ . '/Posts.php';*/

// $user1 = new Users(1, 'Britta', 'Ek', 'britta_ek@email.com');
// var_dump($user1);

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use Blog\Core\Router;
use Blog\Core\Request;

function autoloader($classname)
{
    $lastSlash = strpos($classname, '\\') + 1;
    $classname = substr($classname, $lastSlash);
    $directory = str_replace('\\', '/', $classname);
    $filename = __DIR__ . '/src/' . $directory . '.php';
    require_once($filename);
}

spl_autoload_register('autoloader');

$router = new Router();

$response = $router->route(new Request());

include 'templates/navigation.html';
include 'templates/header.html';
echo $response;
include 'templates/footer.html';