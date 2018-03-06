<?php
//PHP 7 or later
namespace Mdbsp\Database;

use PDO;

class Connection {

    protected $db = null;

    public function open()
    {
        try {

            $dsn    = "mysql:dbname=users; host=localhost";
            $user   = "dbuser";
            $pwd    = "!!dbUser1";

            $options = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            );

            $this->db = new PDO($dsn, $user, $pwd, $options);
            return $this->db;

        }catch (\PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }


    public function close()
    {
        $this->db = null;
        return true;
    }
}
