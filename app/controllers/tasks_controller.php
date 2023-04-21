<?php
use PSr\Http\Message\ResponseInterface as Response;
use PSr\Http\Message\ServerRequestInterface as Request;
use Firebase\JWT\JWT;
use App\Models\Task;
use Slim\Exception\HttpMethodNotAllowedException;
use Slim\Exception\HttpNotFoundException;
require(models_path('Task.php')); 
class TasksController {

    function addTask(Request $request, Response $response, array $args):Response{
        $body=$request->getParsedBody();
        $title=$body['title']??"";
        $descriptoin=$body['description']??"";
        $completed=$body['completed']??false;
        $userId=$request->getAttribute('user')->user_id;

        if(empty($title)){
            return send_response($response,["message"=>"please fill title it's required"],400);
        }

        $task=Task::create(["title"=>$title, "description"=>$descriptoin, "user_id"=>$userId, "completed"=>$completed]);

       return send_response($response,["task"=>$task],201);
    }

    function getAllTasks(Request $request, Response $response, array $args):Response{
        $tasks=Task::all();
       return send_response($response,["tasks"=>$tasks],200);
    }

    function getTasksForUser(Request $request, Response $response, array $args):Response{
        $userId=$request->getAttribute('user')->user_id;

        $tasks=Task::where('user_id',$userId)->get();
       return send_response($response,["tasks"=>$tasks],200);
    }


    function getSingleTaskById(Request $request, Response $response, array $args):Response{
        $userId=$request->getAttribute('user')->user_id;
        $taskId=$args['task_id'];
        $task=Task::find($taskId);
        if(!$task) throw new HttpNotFoundException($request,"There is no task with id " . $taskId);
        if($task->user_id != $userId) throw new HttpMethodNotAllowedException($request,"You are not allowed to view this task");
       return send_response($response,["task"=>$task],200);
    }

    function deleteTask(Request $request, Response $response, array $args):Response{
        $userId=$request->getAttribute('user')->user_id;
        $taskId=$args['task_id'];
        $task=Task::find($taskId);
        if(!$task) throw new HttpNotFoundException($request,"There is no task with id " . $taskId);
        if($task->user_id != $userId) throw new HttpMethodNotAllowedException($request,"You are not allowed to delete this task");
        $task->delete();
        return send_response($response,["task"=>$task,"message"=>"deleted successfully"],200);
    }

    function updateTask(Request $request, Response $response, array $args):Response{
        $body=$request->getParsedBody();
        $title=$body['title']??"";
        $description=$body['description']??"";
        $completed=$body['completed']??false;
        $userId=$request->getAttribute('user')->user_id;
       
        if(empty($title)){
            return send_response($response,["message"=>"please fill title it's required"],400);
        }

        $taskId=$args['task_id'];
        $task=Task::find($taskId);
        if(!$task) throw new HttpNotFoundException($request,"There is no task with id " . $taskId);

        if($task->user_id != $userId) throw new HttpMethodNotAllowedException($request,"You are not allowed to update this task");

        $task->title=$title;
        $task->description=$description;
        $task->completed=$completed;
        $task->save();
        return send_response($response,["task"=>$task,"message"=>"Updated Successfully"],200);
    }

}
?>