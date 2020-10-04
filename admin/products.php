<?php
ob_start();
session_start();
require ('../includes/classes/products.class.php');
require ('../includes/functions/general.function.php');
require ('../includes/classes/uploadImage.class.php');
if(! checkLogin())
{
    header("location:login.php");
    exit();
}
$productObject = new products();

$action = isset($_GET['action']) && $_GET['action'] != null ? $_GET['action'] : 'Manage';

// Manage All Products 
if ($action == 'Manage')
{
    $gettitle = 'All Products';
    $AllProducts = $productObject -> getProducts("ORDER BY `id` DESC");
    include ("../includes/templates/admin/all-products.html");
}

// Add Products 
if ($action == 'Add')
{
    $gettitle = 'Add Product';
    $addErrors = array();
    $successMsg = '';
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        // Filter Inputs 
        $title           = filter_var($_POST['title'],FILTER_SANITIZE_STRING);
        $description     = filter_var($_POST['description'],FILTER_SANITIZE_STRING);
        $price           = filter_var($_POST['price'],FILTER_VALIDATE_FLOAT);
        $availability    = filter_var($_POST['product-availability'],FILTER_SANITIZE_STRING);
        $userid          = $_SESSION['user']['id'];

        if(empty($title))
        {
            $addErrors[] = "Title Can't Be <strong>Empty</strong>";
        }
        if(empty($description))
        {
            $addErrors[] = "Description Can't Be <strong>Empty</strong>";
        }
        
        if(empty($price))
        {
            $addErrors[] = "Price Can't Be <strong>Empty</strong>";
        }
        if($availability != 0 && $availability !=1 )
        {
            $addErrors[] = "Availability Can't Be <strong>Empty</strong>";
        }
        // image Upload 
        $uploadObj       = new uploadImage();
        $prodImage       = $_FILES['prodImage'];
        $uploadObj ->imageName  = $prodImage['name'];
        $uploadObj ->imageSize  = $prodImage['size'];
        $uploadObj ->imageTemp  = $prodImage['tmp_name'];
        $uploadObj ->imageError = $prodImage['error'];

        $uploadErrors =$uploadObj ->checkErrors ();
        if(!empty($uploadErrors))
        {
            foreach($uploadErrors as $error)
            {
                $addErrors[] = $error;
            }
        }

        if(empty($addErrors))
        {
            // creat New Name For Image Before Upload 
            $newImageName = $uploadObj ->generateName();
            // Upload Image 
            if($uploadObj ->uploadFile($newImageName))
            {
                if($productObject ->addProduct($title,$description,$newImageName,$price,$availability,$userid))
                {
                    $successMsg = "Product added successfully...";
                }
                else
                {
                    $addErrors[]= "Something Wrong Please Try Again ";
                }
            }
            else
            {
                $addErrors[]= "Something Wrong In Upload IMage ";
            }     
        }
    }
    include ("../includes/templates/admin/add-product.html");
}

// Edit Products 
if ($action == 'Edit')
{
    $gettitle = 'Edit Product';
    $productid = isset($_GET['productid']) && is_numeric($_GET['productid']) ? intval($_GET['productid']) : 0;
    $editErrors = array();
    $successMsg = '';

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
       // Filter Inputs 
       $title           = filter_var($_POST['title'],FILTER_SANITIZE_STRING);
       $description     = filter_var($_POST['description'],FILTER_SANITIZE_STRING);
       $price           = filter_var($_POST['price'],FILTER_VALIDATE_FLOAT);
       $availability    = filter_var($_POST['product-availability'],FILTER_SANITIZE_STRING);

    //    Image Update 
       $prodImage       = $_FILES['prodImage'];
       $oldImage        = $_POST['oldImage'];
       $newImage        ='';

       if(empty($title))
       {
           $editErrors[] = "Title Can't Be <strong>Empty</strong>";
       }
       if(empty($description))
       {
           $editErrors[] = "Description Can't Be <strong>Empty</strong>";
       }
       
       if(empty($price))
       {
           $editErrors[] = "Price Can't Be <strong>Empty</strong>";
       }
       if($availability != 0 && $availability !=1 )
       {
           $editErrors[] = "Availability Can't Be <strong>Empty</strong>";
       }
       if(empty($prodImage['name']))
       {
           if(! empty($oldImage))
           {
              $newImage  = $oldImage;
           }
           else
           {
              $editErrors[] = "You Must Upload Image";
           } 
       }
       if(! empty($prodImage['name']))
       {
            // image Upload 
            $uploadObj       = new uploadImage();
            $uploadObj ->imageName  = $prodImage['name'];
            $uploadObj ->imageSize  = $prodImage['size'];
            $uploadObj ->imageTemp  = $prodImage['tmp_name'];
            $uploadObj ->imageError = $prodImage['error'];

            $uploadErrors =$uploadObj ->checkErrors ();
            if(! empty($uploadErrors))
            {
                foreach($uploadErrors as $error)
                {
                    $editErrors[] = $error;
                }
            }
            else
            {
                // creat New Name For Image Before Upload 
                $newImage = $uploadObj ->generateName();
                // Upload Image 
                if($uploadObj ->uploadFile($newImage))
                {
                   if(file_exists('../uploads/images/'.$oldImage))
                   {
                       unlink('../uploads/images/'.$oldImage);
                   }
                   else
                   {
                        $editErrors[]= "Something Wrong In Image  Directory ";
                   }
                }
                else
                {
                    $editErrors[]= "Something Wrong In Upload IMage ";
                }
            }
       }

       if(empty($editErrors))
       {

            if($productObject ->updateProduct($productid,$title,$description,$newImage,$price,$availability))
            {
                $successMsg = "Product Updated successfully...";
            }
            else
            {
                $editErrors[]= "Something Wrong Please Try Again ";   
            }
       }
    }

    include ("../includes/templates/admin/edit-product.html");
}

// Delete Product 
elseif($action == 'Delete')
{
    $productid = isset($_GET['productid']) && is_numeric($_GET['productid']) ? intval($_GET['productid']) : 0;
     //Select All Data Depend On This ID
     $check = $productObject ->getProduct($productid);
     if(! empty ($check))
     {
         if($productObject ->deleteProduct($productid))
         {
            if(file_exists('../uploads/images/'.$check['image']))
                unlink('../uploads/images/'.$check['image']);
            header("location:products.php");
         }
         else
         {
             echo 'something Wrong Try Again';
         }
     }
     else
     {
         echo 'Product Is Not Exist';
     }
}
ob_end_flush();
