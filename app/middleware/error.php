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
    
        $typeOfException=explode('\\',get_class($exception));
        $count=count($typeOfException);
        $type=$typeOfException;
        if($count>1){
          $type=$typeOfException[$count-1];
        }
        $payload = [
            'error' =>true,
            'message'=>$exception->getMessage(),
            'type'=>$type,
        ];
    
        $response = $app->getResponseFactory()->createResponse();
        $response->getBody()->write(json_encode($payload, JSON_UNESCAPED_UNICODE));
        $response->withHeader('Content-Type', 'application/json')->withStatus($exception->getCode());
        return $response;
    };
    
    // Add Error Middleware
    $errorMiddleware = $app->addErrorMiddleware(false, true, true);
    $errorMiddleware->setDefaultErrorHandler($customErrorHandler);
};