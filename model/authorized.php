<?php
// php 7 or later
namespace Mdbsp\Authentication;

// the database connection
use Mdbsp\Database\Connection as connection;

class Authorized
{
    private $db = null;

    public function __construct()
    {

        $connect    = new connection();
        $this->db   = $connect->open();

    }

    public function is_authorized($api_key = null)
    {
        try {



        } catch (\PDOException $e) {



        }
    }

    private function check_api($api_key = null)
    {
        try {


        } catch (\PDOException $e) {



        }
    }

}