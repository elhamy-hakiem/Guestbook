<?php
ob_start();
session_start();
$pageTitle="Guestbook.com"; 
// For Show Background From Header File 
$background ='';
$selected ='home';
include "includes/classes/products.class.php";
include "init.php";

// get Latest Products 
$productObj = new products();
$latestProducts = $productObj ->getProducts("ORDER BY `id` DESC LIMIT 3");
?>

<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="section-header">
                <h1>Our Latest Products</h1>
            </div>
        </div>
        <?php 
            if(! empty($latestProducts))
            {
                foreach($latestProducts as $product)
                {
        ?>
                    <div class="col-md-4">
                        <div class="product-box text-center">
                            <?php if($product['available'] == 0){ ?>
                            
                            <div class="product-box-available">
                                Unavailable
                            </div>
                            <?php } ?>

                            <div class="product-box__image">
                                <a href="product.php?pid=<?php echo $product['id'];?>">
                                    <img style="height: 250px; width: 100%;" src="uploads/images/<?php echo file_exists('uploads/images/'.$product['image'])  ? $product['image'] : 'default.png';?>" class="img-responsive" alt="Product Image">
                                    <span><i class="fa fa-star"></i> Product Info</span>
                                </a>
                            </div>
                            <div class="product-box__title">
                                <h2><?php echo $product['title']?></h2>
                            </div>
                            <div class="product-box__desc">
                                <p><?php echo $product['description']?></p>
                            </div>
                            <div class="product-box__price">
                                <span><?php echo $product['price']?><sup>EGP</sup></span>
                            </div>
                            <a href="product.php?pid=<?php echo $product['id'];?>" class="btn btn-lg btn-success"><i class="fa fa-shopping-cart"></i> Buy Now</a>
                        </div>
                    </div>
          <?php }
            }
          ?>
    </div>
</div>

<?php
include $tpl."footer.php"; 
ob_end_flush();
?>
