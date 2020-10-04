<?php
ob_start();
session_start();
require ('../includes/classes/users.class.php');
require ('../includes/functions/general.function.php');
if(! checkLogin())
{
    header("location:login.php");
    exit();
}
$userObject = new users();

$action = isset($_GET['action']) && $_GET['action'] != null ? $_GET['action'] : 'Manage';

// Manage All Users 
if ($action == 'Manage')
{
    $gettitle = 'All User';
    $Allusers = $userObject ->getUsers("ORDER BY `id` DESC");
    include ("../includes/templates/admin/all-users.html");
}
// Add Users 
if ($action == 'Add')
{
    $gettitle = 'Add User';
    $addErrors = array();
    $successMsg = '';
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        // Filter Inputs 
        $fullName        = filter_var($_POST['fullName'],FILTER_SANITIZE_STRING);
        $username        = filter_var($_POST['username'],FILTER_SANITIZE_STRING);
        $email           = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
        $password        = $_POST['password'];
        $confirmPassword = $_POST['confirmPass'];

        // Check If Username Already Exist 
        $user = $userObject ->getUsers("WHERE `username`= '$username'");
        if(! empty($user))
        {
            $addErrors[] = "Username Already <strong>Exist</strong>";
        }
        if(strlen($fullName) < 7 )
        {
            $addErrors[] = "Full Name Must Be Greater Than <strong>6 Chars</strong>";
        }
        if(strlen($username) < 6 )
        {
            $addErrors[] = "Username Must Be Greater Than <strong>5 Chars</strong>";
        }
        if(! filter_var($email,FILTER_VALIDATE_EMAIL))
        {
            $addErrors[] = " Email Address  <strong>Not Valid</strong>";
        }
        if(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,12}$/', $password))
        {
            $addErrors[] = "Password Must Be have at least one number and at least one letter and there have to be 8-12 characters ";
        }
        if($confirmPassword != $password)
        {
            $addErrors[] = "password and Confirm Password <strong>Not Matching</strong>";
        }
        if(empty($addErrors))
        {
            // Hashing Password 
            $hashPassword = password_hash($password,PASSWORD_DEFAULT);
            if($userObject ->addUser($fullName,$username,$hashPassword,$email))
            {
                $successMsg = "User added successfully...";
            }
            else
            {
                $addErrors[]= "Something Wrong Please Try Again ";
            }
        }
    }
    include ("../includes/templates/admin/add-user.html");
}

// Edit Users 
if ($action == 'Edit')
{
    $gettitle = 'Edit User';
    $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
    $editErrors = array();
    $successMsg = '';

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        // Filter Inputs 
        $fullName        = filter_var($_POST['fullName'],FILTER_SANITIZE_STRING);
        $username        = filter_var($_POST['username'],FILTER_SANITIZE_STRING);
        $email           = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
        $oldpassword     = $_POST['oldpassword'];
        $newpassword     = $_POST['newpassword'];

        // Check If Username Already Exist 
        $user = $userObject ->getUsers("WHERE `username`= '$username' AND `id` != '$userid'");
        if(! empty($user))
        {
            $editErrors[] = "Username Already <strong>Exist</strong>";
        }
        if(strlen($fullName) < 7 )
        {
            $editErrors[] = "Full Name Must Be Greater Than <strong>6 Chars</strong>";
        }
        if(strlen($username) < 6 )
        {
            $editErrors[] = "Username Must Be Greater Than <strong>5 Chars</strong>";
        }
        if(! filter_var($email,FILTER_VALIDATE_EMAIL))
        {
            $editErrors[] = " Email Address  <strong>Not Valid</strong>";
        }
        if(! empty($newpassword))
        {
            if(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,12}$/', $newpassword))
            {
                $editErrors[] = "Password Must Be have at least one number and at least one letter and there have to be 8-12 characters  ";
            }
            else
            {
                $newpassword = password_hash($newpassword,PASSWORD_DEFAULT);
            }
        }
        if(empty($newpassword))
        {
            $newpassword = $oldpassword;
        }
        if(empty($editErrors))
        {
            if($userObject ->updateUser($userid,$fullName,$username,$newpassword,$email))
            {
                $successMsg = "User Updated successfully...";
            }
            else
            {
                $editErrors[]= "Something Wrong Please Try Again ";
            }
        }
    }

    include ("../includes/templates/admin/edit-user.html");
}

// Delete User 
elseif($action == 'Delete')
{
    $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
     //Select All Data Depend On This ID
     $check = $userObject ->getUser($userid);
     if(! empty ($check))
     {
         if($userObject ->deleteUser($userid))
         {
           header("location:users.php");
         }
         else
         {
             echo 'something Wrong Try Again';
         }
     }
     else
     {
         echo 'User Is Not Exist';
     }
}


ob_end_flush();
