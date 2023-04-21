<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class AuthMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $token = $request->getHeaderLine('Authorization');

        if (!$token) {
            // Token not found, return a 401 Unauthorized response
            return new Response(401);
        }
    
        // Verify the token signature and decode the payload
        try {
            $payload = JWT::decode($token, new Key($_ENV['SECERET_KEY'], $_ENV['ALGORITHM']));
        } catch (Exception $e) {
            // Token is invalid, return a 401 Unauthorized response
            return new Response(401);
        }
    
        // Add the decoded payload to the request attributes
        $request = $request->withAttribute('token', $payload);
    
        // Call the next middleware
        $response = $handler->handle($request);
    
        return $response;
    }
}
?>