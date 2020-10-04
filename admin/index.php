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


include ("../includes/templates/admin/index.html");
ob_end_flush();
