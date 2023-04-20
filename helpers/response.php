<?php
use Psr\Http\Message\ResponseInterface as Response;

if(!function_exists('send_response')){
 function send_response(Response $response,array $data,int $statusCode):Response{
    $response->getBody()->write(json_encode($data));
    return $response->withHeader('content-type',"application/json")->withStatus($statusCode);
  }
}
?>