<?php
ob_start();
session_start();
require ('../includes/classes/users.class.php');
require ('../includes/functions/general.function.php');

if(checkLogin())
{
    header("location:index.php");
    exit();
}
$loginErrors = array();
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $username = filter_var($_POST['username'],FILTER_SANITIZE_STRING);
    $password = $_POST['password'];

    $userObject = new users();

    if(!empty($username) && ! empty($password))
    {
        // Check If User Exist Or E_Not
        $user =  $userObject ->login($username);
        if(! empty($user))
        {
            $getPassword = $user['password'];
            // echo password_verify($password,$getPassword);
            // exit;
            if(password_verify($password,$getPassword))
            {
                $_SESSION['user']= $user;
                header("location:index.php");
            }
            else
            {
                $loginErrors[]= 'Please Type Correct Password';
            }
        }
        else
        {
            $loginErrors[] ='Username Is Not Exist';
        }
    }
    else
    {
        $loginErrors[] ='Please Fill All Fields';
    }
}

include ("../includes/templates/admin/login.html");
ob_end_flush();
