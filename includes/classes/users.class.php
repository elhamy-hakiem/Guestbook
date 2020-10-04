<?php
require ('dbconn.class.php');
class users extends dbconn
{
    //Add new user 
    public function addUser($fullName,$username,$password,$email)
    {
        $stmt = $this-> connection()->prepare("INSERT INTO `users`(`fullName`,`username`, `password`, `email`) 
                                                        VALUES (:fullName, :username, :password, :email)");
        $result = $stmt ->execute(array(
            'fullName'   => $fullName,
            'username'   => $username,
            'password'   => $password,
            'email'      => $email
        ));
        if($result)
        {
            return true;
        }
        return false;
    }

    // Update User 
    public function updateUser($id,$fullName,$username,$password,$email)
    {
        $sql = "UPDATE `users` SET ";
        if(! empty($fullName))
        {
            $sql .="`fullName`='$fullName' ,";
        }
        if(! empty($username))
        {
            $sql .="`username`='$username' ,";
        }
        if(! empty($password))
        {
            $sql .="`password`='$password' ,";
        }
        if(! empty($email))
        {
            $sql .="`email`='$email' ";
        }
        $sql .=" WHERE `id` = :id ";

        // return integer id 
        $id = intval($id);

        $stmt = $this ->connection() ->prepare($sql);
        $stmt ->bindParam(":id",$id);
        $result = $stmt ->execute();
        if($result)
        {
            return true;
        }
        return false;
    }

    // Delete User 
    public function deleteUser($id)
    {
        $stmt = $this ->connection() ->prepare("DELETE FROM `users` WHERE id = :id");
        $stmt ->bindParam(":id",$id);
        $result = $stmt ->execute();

        if($result)
        {
            return true;
        }
        return false;
    }

    // Get All User 
    public function getUsers($extra ='')
    {
        $stmt = $this ->connection() ->prepare("SELECT * FROM `users` $extra ");
        $stmt ->execute();
        $result = $stmt ->fetchAll();
        if($result && count($result) > 0)
        {
            return $result;
        }
        return null;
    }

    // Get User By ID 
    public function getUser($id)
    {
        $id = intval($id);
        $users = $this ->getUsers("WHERE `id` = $id ");
        if($users && count($users) > 0 )
        {
            return $users[0];
        }
        return null;
    }

    public function login($username)
    {
        $users = $this ->getUsers("WHERE `username` = '$username'");
        if($users && count($users) > 0 )
        {
            return $users[0];
        }
        return null;
    }
}