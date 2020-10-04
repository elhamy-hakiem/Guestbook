<?php

class dbconn
{
    protected $host = "localhost";
    protected $dbname = "guestbook";
    protected $user = "root";
    protected $password = "";
    protected $option = array (
        PDO::MYSQL_ATTR_INIT_COMMAND =>'SET NAMES utf8'
    );
    public function connection()
    {
        $dsn ='mysql:host='.$this->host.';dbname='.$this->dbname;
        try
        {
            $connection = new PDO($dsn,$this->user,$this->password,$this->option);
            $connection ->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            return $connection;
        }

        catch(PDOException $e)
        {
            return "faild to connect". $e->getMessage();
        }
    }
}