<?php
require ('dbconn.class.php');
class messages extends dbconn
{
    // Add New Message 
    public function addMessage($title,$content,$name,$email)
    {
        $stmt = $this->connection()->prepare("INSERT INTO 
                                                    `messages`
                                                    (`title`, `content`, `name`, `email`) 
                                              VALUES 
                                                    (:title, :content, :name, :email)");
        $result = $stmt->execute(array(
            'title'     => $title,
            'content'   => $content,
            'name'      => $name,
            'email'     => $email
        ));

        if($result)
        {
            return true;
        }
        return false;
    }

     // Update Message 
     public function updateMessage($id,$title,$content)
     {
         $stmt = $this->connection()->prepare("UPDATE `messages` 
                                                  SET 
                                                    `title`    = :title,
                                                    `content`  =:content
                                                 WHERE
                                                    `id`       = :id ");
         $result = $stmt->execute(array(
             'title'     => $title,
             'content'   => $content,
             'id'        => $id
         ));
         if($result)
         {
             return true;
         }
         return false;
     }

    // Delete Message 
    public function deleteMessage($id)
    {
        $stmt = $this->connection()->prepare("DELETE FROM `messages` WHERE `id` = :id");
        $stmt ->bindParam(":id",$id);
        $result = $stmt ->execute();
        if($result)
        {
            return true;
        }
        return false;
    }

    // Get All Messages 
    public function getMessages($extra='')
    {
        $stmt = $this ->connection() ->prepare("SELECT * FROM `messages` $extra ");
        $stmt ->execute();
        $result = $stmt ->fetchAll();
        if($result && count($result) > 0)
        {
            return $result;
        }
        return null;
    }

    // Get Message 
    public function getMessage($id)
    {
        $id = intval($id);
        $messages = $this ->getMessages("WHERE `id` = $id ");
        if($messages && count($messages) > 0 )
        {
            return $messages[0];
        }
        return null;
    }
   
 

}