<?php
ob_start();
session_start();
$pageTitle="Products"; 
$selected ='products';
include "includes/classes/products.class.php";
include "init.php";

// get Latest Products 
$productObj = new products();
$AllProducts = $productObj ->getProducts("ORDER BY `id` DESC");
?>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="section-header">
                    <h1>Our Products</h1>
                </div>
            </div>
            <?php 
            if(! empty($AllProducts))
            {
                foreach($AllProducts as $product)
                {
            ?>
                    <div class="col-md-4">
                        <div class="product-box text-center">
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
