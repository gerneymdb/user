<?php
require_once "includes.php";
header("Access-Control-Allow-Methods: DELETE");

// using user class as users alias
use Mdbsp\Users\User as users;

$users = new users();

if($_SERVER["REQUEST_METHOD"] === "DELETE"){

    // get data
    $data = json_decode(file_get_contents("php://input"), true);

    // checks if it is a json
    if($data != null){

        if(array_key_exists("userid", $data)){

            // check userid must be int
            if(is_int($data["userid"])){

                // check if userid exist
                $exist = $users->getUsers($data["userid"]);

                if(count($exist) > 0){

                    // userid exist delete user
                    if($users->deleteUser($data["userid"])){

                        echo json_encode(["message"=> "success"]);
                        http_response_code(200);
                    }

                }else {
                    // userid does not exist

                    echo json_encode(["message" => "user does not exist"]);
                    http_response_code(400);
                }

            }else {

                $type = gettype($data["userid"]);
                echo json_encode(["message" => "userid must be int: {$type} given"]);
                http_response_code(400);
            }

        }else {

            echo json_encode(["message" => "No userid in the parameter"]);
            http_response_code(400);
        }

    }else {

        echo json_encode(["message" => "Invalid input: expects json formatted input.!"]);
        http_response_code(400);
    }

}else {

    echo "Bad Request.!";
    http_response_code(400);

}