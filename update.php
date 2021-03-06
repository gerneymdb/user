<?php
require_once "includes.php";
header("Access-Control-Allow-Methods: PUT");

// using user class as users alias
use Mdbsp\Users\User as users;

$users = new users();

if($_SERVER["REQUEST_METHOD"] === "PUT"){

    // get data
    $data = json_decode(file_get_contents("php://input"), true);

    // checks if it is a json
    if($data != null){

        // check if all fields are present
        $required_fields = ["userid", "username", "password", "emailaddress", "group"];

        // all required fields indicator
        $are_fields_complete = false;

        foreach ($required_fields as $field) {

            if(!array_key_exists($field, $data)){
                // if a field don't exist give error
                echo json_encode(["message" => "{$field} is required"]);
                http_response_code(400);
                $are_fields_complete = false;
                break;

            }else {

                $are_fields_complete = true;
            }

        }

        // validate for an empty string
        if($are_fields_complete){

            $error = [];

            foreach ($data as $keys => $value) {

                switch($keys){
                    case "userid":

                        $value = trim($value);
                        if(empty($value)){
                            $error[] = "User id is required.!";
                        }

                        if(!is_numeric($value)){
                            $error[] = "User id must be numeric.!";
                        }

                        break;
                    case "username":

                        $value = trim($value);
                        if(empty($value)){
                            $error[] = "Username is required.! ";
                        }

                        if(!is_string($value)){
                            $error[] = "Username must be a string.! ";
                        }

                        break;
                    case "password":

                        $value = trim($value);
                        if(empty($value)){
                            $error[] = "Password is required.! ";
                        }

                        if(!is_string($value)){
                            $error[] = "Password must be a string.! ";
                        }

                        break;
                    case "group":

                        $value = trim($value);
                        if(empty($value)){
                            $error[] = "Group is required.!";
                        }

                        if(!is_numeric($value)){
                            $error[] = "Group must be numeric.!";
                        }

                        break;
                    case "emailaddress":

                        $value = trim($value);
                        if(empty($value)){
                            $error[] = "Email address is required.!";
                        }

                        if(filter_var($value, FILTER_VALIDATE_EMAIL) == false){
                            $error[] = "Email is not valid.!";
                        }

                        break;
                }

            }


            if(count($error) > 0){
                // has validation error

                echo json_encode(["message" => $error]);
                http_response_code(400);

            }else {

                // no validation error
                // check if user exist

                $exist = $users->getUsers($data["userid"]);

                if(count($exist) > 0){

                    $userid     = filter_var($data["userid"], FILTER_SANITIZE_STRING);
                    $username   = filter_var($data["username"], FILTER_SANITIZE_STRING);
                    $password   = filter_var($data["password"], FILTER_SANITIZE_STRING);
                    $group      = filter_var($data["group"], FILTER_SANITIZE_STRING);
                    $email      = filter_var($data["emailaddress"], FILTER_SANITIZE_EMAIL);

                    $user_data = ["userid" => $userid, "username" => $username, "password" => $password, "group" => $group, "emailaddress" => $email];

                    if($users->updateUser($user_data)){

                        echo json_encode(["message"=> "success"]);
                        http_response_code(200);

                    }else {

                        echo json_encode(["message" => "failed to update user. please contact the system administrator"]);
                        http_response_code(200);
                    }

                }else {

                    // userid does not exist

                    echo json_encode(["message" => "user does not exist"]);
                    http_response_code(400);

                }

            }

        }

    }else {

        echo json_encode(["message" => "Invalid input: expects json formatted input.!"]);
        http_response_code(400);
    }

}else {

    echo "Bad Request.!";
    http_response_code(400);

}