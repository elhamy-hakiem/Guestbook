<?php

//Error Repprting
ini_set('display_errors','on');
error_reporting(E_ALL);

//Routes
$func = 'includes/functions/';    //functions directory
$tpl = 'includes/templates/';    //templates directory
$css = 'assets/css/';           //css directory
$js = 'assets/js/';            //js directory



//Includes Important Files
include $func."general.function.php";
include $tpl."header.php"; 
