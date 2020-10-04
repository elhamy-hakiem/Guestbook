<?php
ob_start();
session_start();
require ('../includes/classes/messages.class.php');
require ('../includes/functions/general.function.php');
require ('../includes/classes/uploadImage.class.php');
if(! checkLogin())
{
    header("location:login.php");
    exit();
}
$messageObj = new messages();

$action = isset($_GET['action']) && $_GET['action'] != null ? $_GET['action'] : 'Manage';

// Manage All Messages 
if ($action == 'Manage')
{
    $gettitle = 'All Messages';
    $AllMessages = $messageObj -> getMessages("ORDER BY `id` DESC");
    include ("../includes/templates/admin/all-messages.html");
}

// Edit Message 
if ($action == 'Edit')
{
    $gettitle = 'Edit Message';
    $msgid = isset($_GET['msgid']) && is_numeric($_GET['msgid']) ? intval($_GET['msgid']) : 0;
    $editErrors = array();
    $successMsg = '';

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        // Filter Inputs 
        $title           = filter_var($_POST['title'],FILTER_SANITIZE_STRING);
        $content         = filter_var($_POST['content'],FILTER_SANITIZE_STRING);
       
        if(strlen($title) < 6)
        {
            $editErrors[] = 'Message Title Must Be Greater Than 6 Chars'; 
        }
        if(strlen($content) < 6)
        {
            $editErrors[] = 'Message Content Must Be Greater Than 6 Chars'; 
        }
        if(empty($editErrors))
        {
            if($messageObj ->updateMessage($msgid,$title,$content))
            {
                $successMsg = "Message Updated Success";
            }
            else
            {
                $editErrors[] = "Something Went Wrong Try Again";
            }
        }
      
    }

    include ("../includes/templates/admin/edit-message.html");
}


// Delete Message 
elseif($action == 'Delete')
{
    $msgid = isset($_GET['msgid']) && is_numeric($_GET['msgid']) ? intval($_GET['msgid']) : 0;
     //Select All Data Depend On This ID
     $check = $messageObj ->getMessage($msgid);
     if(! empty ($check))
     {
         if($messageObj ->deleteMessage($msgid))
         {
            header("location:messages.php");
         }
         else
         {
             echo 'something Wrong Try Again';
         }
     }
     else
     {
         echo 'Message Is Not Exist';
     }
}
ob_end_flush();
