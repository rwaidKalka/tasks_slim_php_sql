<?php
use App\Models\User;
use PSr\Http\Message\ResponseInterface as Response;
use PSr\Http\Message\ServerRequestInterface as Request;
use Firebase\JWT\JWT;
require(models_path('User.php'));

class AuthController{
    function login(Request $request, Response $response, array $args):Response{
        $body=$request->getParsedBody();

        $email=$body['email']??'';
        $password=$body['password']??'';
        
        if(empty($email) || empty($password)) {
            $payload=["error"=>true,"message"=>"Please enter your email address and password."];
            return send_response($response,$payload,400);
        }

        $user = User::where('email', '=', $email)->first();

        if(!$user){
            $payload=["error"=>true,"message"=>"There is no user with the coresponding email."];
            return send_response($response,$payload,400);
        }

        ///compare by hash
        if(!password_verify($password,$user->password)){
            return send_response($response,["error"=>true,"message"=>"invalid credintials"],401);

        }

        $payload = array(
            "sub" => $user->id,
            "iat" => time(),
        );
        $jwt = JWT::encode($payload, $_ENV['SECERET_KEY'],$_ENV["ALGORITHM"]);

        return send_response($response,["user"=>$user,"token"=>$jwt],400);
}

    function register(Request $request, Response $response, array $args):Response{
        
        $body=$request->getParsedBody();

        $email=$body['email']??'';
        $username=$body['username']??'';
        $password=$body['password']??'';
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        
        if(empty($username) || empty($email) || empty($password)) {
            $payload=["error"=>true,"message"=>"Please enter your username , email address and password."];
            return send_response($response,$payload,400);
        }


        $userExists=User::where('email',$email)->first();

        if($userExists){
            $payload=["error"=>true,"message"=>"This email is already in use please use another email."];
           return send_response($response,$payload,400);
        }

        $user=User::create(['username'=>$username,'email'=>$email, 'password' => $hashedPassword]);

        $payload = array(
            "sub" => $user->id,
            "iat" => time(),
        );
        $jwt = JWT::encode($payload, $_ENV['SECERET_KEY'],$_ENV["ALGORITHM"]);

        $data=[ 
            "user" => $user,
            "token"=>$jwt,
        ];
        return send_response($response,$data,400);
    }


    function logout(Request $request, Response $response, array $args):Response{
        return send_response($response,["messsage"=>"logged out successfully"],400);
    }
}