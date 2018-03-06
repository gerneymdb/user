<?php
//PHP 7 or later
namespace Mdbsp\Users;

// the database connection
use Mdbsp\Database\Connection as connection;

class User
{

    private $db = null;

    public function __construct()
    {

        $connect    = new connection();
        $this->db   = $connect->open();

    }

    public function getUsers($userid = null)
    {
        try {

            $stmt = null;

            if(is_null($userid)){

                // if userid is null, get all users
                $stmt = $this->db->prepare("SELECT * FROM user");
                $stmt->execute();

            }else{

                // if userid is not null, get user
                $stmt = $this->db->prepare("SELECT * FROM user WHERE userid=?");
                $stmt->execute([$userid]);

            }

            $user = $stmt->fetchAll();
            return $user;

        }catch (\PDOException $e){
            echo "Oops: ". $e->getMessage();
        }

    }

    public function getByUsername($username = null)
    {
        try {

            $stmt = null;

            if(!is_null($username)){

                // if username is not null, get user
                $stmt = $this->db->prepare("SELECT * FROM user WHERE username=?");
                $stmt->execute([$username]);

            }

            $user = $stmt->fetchAll();
            return $user;

        }catch (\PDOException $e){
            echo "Oops: ". $e->getMessage();
        }

    }

    public function deleteUser($userid = null)
    {
        try {

            $stmt = null;

            if(!is_null($userid)){

                $stmt = $this->db->prepare("DELETE FROM user WHERE userid=? LIMIT 1");
                $stmt->execute([$userid]);
                $affected_rows = $stmt->rowCount();

                if($affected_rows > 0){
                    return true;
                }else {
                    return false;
                }

            }else{

                echo  "Supplied parameter is null.!";

            }

        }catch (\PDOException $e) {

            echo "Oops: ".$e->getMessage();

        }

    }

    public function updateUser($data = null)
    {
        try {

            $stmt = null;

            if(!is_null($data)) {

                $stmt = $this->db->prepare("UPDATE `user` SET `username`=?, `password`=?, `emailaddress`=?, `group`=? WHERE `userid`=?");

                // returns boolean
                return $stmt->execute([$data["username"], $data["password"],$data["emailaddress"], $data["group"], $data["userid"]]);

            }else{

                echo  "Supplied parameter is null.!";

            }

        }catch (\PDOException $e){

            echo "Oops: ".$e->getMessage();

        }

    }

    public function createUser($data = null)
    {
        try {

            $stmt = null;

            if(!is_null($data)) {

                $stmt = $this->db->prepare("INSERT INTO `user` (`username`, `password`, `emailaddress`, `group`) VALUES (?, ?, ?, ?)");

                // returns boolean
                $stmt->execute([$data["username"], $data["password"],$data["emailaddress"], $data["group"]]);

                // return last inserted id

                return $this->db->lastInsertId();

            }else{

                echo  "Supplied parameter is null.!";

            }

        } catch (\PDOException $e) {

            echo "Oops: ".$e->getMessage();

        }
    }

}