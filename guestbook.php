<?php
ob_start();
session_start();
$pageTitle="Guset Book"; 
$selected ='gb';
include "includes/classes/messages.class.php";
include "init.php";
$messageObj = new messages();

$addErrors = array();
$successMsg ='';

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $title     = filter_var($_POST['title'],FILTER_SANITIZE_STRING);
    $content   = filter_var($_POST['content'],FILTER_SANITIZE_STRING);
    $name      = filter_var($_POST['name'],FILTER_SANITIZE_STRING);
    $email     = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);

    if(strlen($title) < 6)
    {
        $addErrors[] = 'Message Title Must Be Greater Than 6 Chars'; 
    }
    if(strlen($content) < 6)
    {
        $addErrors[] = 'Message Content Must Be Greater Than 6 Chars'; 
    }
    if(strlen($name) < 8)
    {
        $addErrors[] = 'You Must Be Type Full Name'; 
    }
    if(! filter_var($email,FILTER_VALIDATE_EMAIL))
    {
        $addErrors[] = 'YouR Email Is Not Valid';
    }
    if(empty($addErrors))
    {
        if($messageObj ->addMessage($title,$content,$name,$email))
        {
            $successMsg = "Message Added Success";
        }
        else
        {
            $addErrors[] = "Something Went Wrong Try Again";
        }
    }
}
?>
<div class="content">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="section-header">
                <h1>Guest Book</h1>
            </div>
            <div class="row guestbook">
                <div class="col-md-12">
                    <!-- Start Show Alert Messages  -->
                    <?php 
                        if(! empty($addErrors)) 
                        { 
                            foreach($addErrors as $error)
                            {
                                echo ' <div class="alert alert-danger">
                                            <p>'.$error.'</p>
                                        </div>';
                            }
                        }
                    ?>
                    <?php 
                        if(! empty($successMsg)) 
                        { 
                            echo ' <div class="alert alert-success">
                                        <p>'.$successMsg.'</p>
                                    </div>';
                        }
                    ?>
                    <!-- End Show Alert Messages  -->
                    <!-- Start Fetch All Messages  -->
                    <?php 
                        $allMessages = $messageObj ->getMessages("ORDER BY `ID` DESC");
                        if(!empty($allMessages))
                        {
                            foreach($allMessages as $message)
                            {

                    ?>
                                <div class="panel panel-default panel-guestbook">
                                    <div class="panel-heading">
                                        <div class="guestbook__title"><?php echo $message['title'];?></div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="guestbook__text"><?php echo $message['content'];?></div>
                                    </div>
                                    <div class="panel-footer">
                                        <div class="guestbook__writer"><strong>Added By:</strong> <?php echo $message['name'];?></div>
                                    </div>
                                </div>
                    <?php 
                            }
                        }
                    ?>
                    <!-- End Fetch All Messages  -->
                </div>

                <div class="col-md-12">
                    <div class="section-header">
                        <h1>Add new message</h1>
                    </div>

                    <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="title" class="col-sm-3 control-label">Message Title</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="title" name="title" placeholder="Message Title">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="content" class="col-sm-3 control-label">Message Content</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" rows="6" id="content" name="content" placeholder="Message Content"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-3 control-label">Your Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Your Name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-sm-3 control-label">Your Email</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="email" name="email" placeholder="Your Email">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-9">
                                <button type="submit" class="btn btn-danger"><i class="fa fa-comments"></i> Add Message</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<?php
include $tpl."footer.php"; 
ob_end_flush();
?>
