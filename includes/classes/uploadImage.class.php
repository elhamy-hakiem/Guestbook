<?php 

class uploadImage 
{
   public $imageName;
   public $imageSize;
   public $imageTemp;
   public $imageError;
   // List Of Allowed File Type To Upload 
   private $imageAllowedExtension = array("jpeg","jpg","png","gif");

   public function getExtention()
   {
         //Get Image Extension
         $arrayName = explode(".",$this->imageName);
         $imageExtension = strtolower(end($arrayName));
         return $imageExtension ;
   }

   public function checkErrors ()
   {
       $errors = array();

       if($this->imageError == 4)
       {
           $errors[] = 'You are Not Choosed File To uploaded.';
       }
       else
       {
            if(! in_array($this->getExtention(),$this->imageAllowedExtension))
            {
                $errors[] = "This Extension is Not <strong>Allowed</strong>";
            }
            else
            {
                if($this->imageError == 1)
                {
                    $errors[] = 'The file size exceeds the value specified.';
                }
                if($this->imageError == 2)
                {
                    $errors[] = 'The file size exceeds the value of the directive.';
                }
                if($this->imageError == 3)
                {
                    $errors[] = 'The file is not completely uploaded.';
                }
                if($this->imageError == 6)
                {
                    $errors[] = 'The temporary directory does not exist.';
                }
                if($this->imageSize > 512000)
                {
                    $errors[] = "Image Can't Be Larger Than <strong>500 kB</strong>";
                }
            }
       }

       return $errors ;
   }


   public function generateName()
   {    
       $newName = md5(rand(0,10000000000)).'_'.$this->imageName;
       return $newName;
   }

   public function uploadFile($newName)
   {
        if (is_uploaded_file($this->imageTemp))
        { 
            move_uploaded_file($this->imageTemp, "../uploads/images/".$newName);
            return true ;  
        }
        else
        { 
            return false ;
        }
   }

  
}