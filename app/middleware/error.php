<?php
use Psr\Log\LoggerInterface;
use Slim\App;
use Psr\Http\Message\RequestInterface as Request;

return function(App $app){
     
    $customErrorHandler = function (
        Request $request,
        Throwable $exception,
        bool $displayErrorDetails,
        bool $logErrors,
        bool $logErrorDetails,
        ?LoggerInterface $logger = null
    ) use ($app) {
           
        $payload = [
            'error' =>true,
            'message'=>$exception->getMessage(),
            'code'=>$exception->getCode(),
        ];

        $statusCode=(int)$exception->getCode()??500;
        $statusCode=$statusCode>500 || $statusCode<100?500:$statusCode;

        $response = $app->getResponseFactory()->createResponse();
        $response->getBody()->write(json_encode($payload, JSON_UNESCAPED_UNICODE));
        return $response->withStatus($statusCode)->withHeader('Content-Type', 'application/json');
    };
    
    // Add Error Middleware
    $errorMiddleware = $app->addErrorMiddleware(true, true, true);
    $errorMiddleware->setDefaultErrorHandler($customErrorHandler);
};