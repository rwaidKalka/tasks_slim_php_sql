<?php
use Slim\Factory\AppFactory;
use Dotenv\Dotenv;

require __DIR__ . '/../vendor/autoload.php';

///Load Environment Variables
$dotenv = Dotenv::createImmutable(base_path());
$dotenv->load();


///Configre Database Connection
$config=require(config_path('db.php'));
$config();

$app=AppFactory::create();

$app->addBodyParsingMiddleware();

$app->post('/',function($req,$res){
    $res->getBody()->write(json_encode($_ENV));
    return $res;
});

///Routes
$authRoutes=require(routes_path('auth_routes.php'));
$authRoutes($app);

///Error Middleware
$errorMiddleware=require(middleware_path('error.php'));
$errorMiddleware($app);

///Not Found Middleware
$notFoundMiddleware=require(middleware_path('not_found.php'));
$notFoundMiddleware($app);


$app->run();
?>