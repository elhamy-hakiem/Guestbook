<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php getTitle();?></title>
    <link rel="icon" href="assets/images/icon.png">
    <!-- fonts style  -->
   
      <!-- FontAwesome -->
      <link href="<?php echo $css; ?>font-awesome.min.css" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="<?php echo $css; ?>bootstrap.min.css" rel="stylesheet">

    <!-- Style -->
    <link href="<?php echo $css; ?>style.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="index.php"><img src="assets/images/share-logo.jpg" class="img-responsive" alt=""></a>
                    </div>

                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">
                            <li <?php echo ($selected == 'home') ? 'class="active"':'';?> ><a href="index.php">Home <span class="sr-only">(current)</span></a></li>
                            <li <?php echo ($selected == 'products') ? 'class="active"':'';?>><a href="products.php">Products</a></li>
                            <li <?php echo ($selected == 'gb') ? 'class="active"':'';?>><a href="guestbook.php">Guest Book</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
        <?php if(isset($background))
                {
                    echo '  <div class="col-md-12">
                                <div class="jumbotron">
                                    <h1><i class="fa fa-heart"></i> Welcome to our store!</h1>
                                    <p>You will find the latest trendy clothes with the lowest prices in the market. We are dealing with high quality factories for the best wear experience...</p>
                                    <p><a class="btn btn-danger btn-lg" href="#" role="button">Learn more</a></p>
                                </div>
                            </div>';
                }
        ?>
    </div>
