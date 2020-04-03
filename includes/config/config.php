<?php
/**
 * User: Matthias
 * Date: 29/10/2019
 * Time: 09:22
 */
class config
{
    private static $configInstance = null;

    private $server;
    private $database;
    private $username;
    private $password;

    private function __construct(){
        $this->server = "localhost";
        $this->database = "mechatronica";
        $this->username = "root";
        $this->password = "";
    }
    public static function getInstance()
    {
        if(is_null(self::$configInstance))
        {
            self::$configInstance = new Config();
        }
        return self::$configInstance;
    }

    public function getServer()
    {
        return $this->server;
    }
    public function getDatabase()
    {
        return $this->database;
    }
    public function getUsername()
    {
        return $this->username;
    }
    public function getPassword()
    {
        return $this->password;
    }
}
?>