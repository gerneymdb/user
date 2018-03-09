<?php
require_once "includes.php";
header("Access-Control-Allow-Methods: GET");

// using user class as users alias
use Mdbsp\Users\User as users;

if($_SERVER["REQUEST_METHOD"] === "GET"){

    // an instance of a users class
    $users = new users();

    if(isset($_GET["userid"])){
        // get on user record

        $userid = $_GET["userid"];

        // check if its numeric or int
        if(is_numeric($userid)){
            // get all users data from the database
            $list = $users->getUsers($userid);

            if(count($list) > 0){

                echo json_encode($list);
                // send http response 200 means success
                http_response_code(200);
            }else {

                echo json_encode(["message" => "Requested user does not exist"]);
                http_response_code(400);
            }


        }else{

            // get variable type
            $type = gettype($userid);

            echo json_encode(["message" => "Invalid data format:".$type." given INT needed.!"]);
            http_response_code(400);
        }


    }else{
        // get all user record

        // get all users data from the database
        $list = $users->getUsers();

        // return json formatted data
//        echo json_encode($list);
        echo json_encode([$_SERVER["REMOTE_ADDR"], $_SERVER["HTTP_USER_AGENT"], $_SERVER["SERVER_NAME"]]);

        // send http response 200 means success
        http_response_code(200);

    }

}else {

    echo "Bad Request.!";
    http_response_code(400);

}
