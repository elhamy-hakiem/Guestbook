<?php
function checkLogin()
{
    return isset($_SESSION['user']) ? true :false;
}
//  Function to change page title 
//version(1.0)
function getTitle()
{
    global $pageTitle ;
    if(isset($pageTitle)){echo $pageTitle;}
    else{echo "Default";}
}

