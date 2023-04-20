<?php
use Slim\App;
use PSr\Http\Message\ResponseInterface as Response;
use PSr\Http\Message\ServerRequestInterface as Request;


return function(App $app){
    $app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function (Request $request,Response $response) {
      
        $payload = [
            'error' => true,
            'message'=>"route doesn't exist",
        ];

        $response->getBody()->write(json_encode($payload));
        $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        return $response;
    });
};