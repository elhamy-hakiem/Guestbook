<?php
ob_start();
session_start();
$pageTitle="Product Info"; 
$selected = 'product'; 
include "includes/classes/products.class.php";
include "init.php";
$productid = isset($_GET['pid']) && is_numeric($_GET['pid']) ? intval($_GET['pid']) : 0;
$productObj = new products();
// Fetch Product Information 
$productInfo = $productObj ->getProduct($productid);
?>

<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="section-header">
                <h1>Product Info</h1>
            </div>
        </div>
    </div>
    <div class="row product-info">
        <!-- Start Check IF found Data Depend On This Id Or Not  -->
        <?php 
            if(! empty($productInfo))
            {
        ?>
                <div class="col-md-8">
                    <div class="product-info__title">
                        <h2><?php echo $productInfo['title'];?></h2>
                    </div>
                    <div class="product-info__price">
                        <strong>Product Price:</strong> <span><?php echo $productInfo['price'];?><sup>EGP</sup></span>
                    </div>
                    <div class="product-info__available">
                        <strong>Product Availability:</strong> <span><?php echo $productInfo['available'] == 1 ? 'Available' : 'Not Available';?></span>
                    </div>
                    <div class="product-info__desc">
                        <h2>Product Description:</h2>
                        <p><?php echo $productInfo['description'];?></p>
                    </div>
                    <br />
                    <a href="#" class="btn btn-lg btn-danger"><i class="fa fa-shopping-cart"></i> Buy Now</a>
                </div>
                <div class="col-md-4">
                    <div class="product-info__image">
                        <img style="height: 334px; width: 100%;" src="uploads/images/<?php echo file_exists('uploads/images/'.$productInfo['image'])  ? $productInfo['image'] : 'default.png';?>" class="img-responsive" alt="">
                    </div>
                </div>
        <?php 
            }
            else
            {
                header("location:index.php");
            }
        ?>
    </div>
</div>

<?php
include $tpl."footer.php"; 
ob_end_flush();
?>
