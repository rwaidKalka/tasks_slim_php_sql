<?php
use Slim\App;
use Slim\Routing\RouteCollectorProxy;
require(controllers_path('tasks_controller.php'));

return function(App $app){
    $app->group('/api/tasks',function(RouteCollectorProxy $group){
      $group->get('',TasksController::class.":getAllTasks");
      $group->get('/myTasks',TasksController::class.":getTasksForUser");
      $group->get('/{task_id}',TasksController::class.":getSingleTaskById");
      $group->post('',TasksController::class.":addTask");
      $group->put('/{task_id}',TasksController::class.":updateTask");
      $group->delete('/{task_id}',TasksController::class.":deleteTask");
    })->add(new AuthMiddleware());
};
