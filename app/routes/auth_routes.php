<?php
use Slim\App;
use Slim\Routing\RouteCollectorProxy;
require(controllers_path('auth_controller.php'));
$authMiddleware=require(middleware_path('auth.php'));

return function(App $app){
    $app->group('/api/auth',function(RouteCollectorProxy $group){
      $group->post('/login',AuthController::class.":login");
      $group->post('/logout',AuthController::class.":logout")->add(new AuthMiddleware());
      $group->post('/register',AuthController::class.":register");
    });
};