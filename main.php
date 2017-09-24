<?php 
  require_once("../includes/layouts/header.php"); 

  $samsungItems = $product->findAllItemsByBrand(1, $lim = 4, true);
  $lgItems      = $product->findAllItemsByBrand(2, $lim = 4, true);
  $img_src      = IMAGE_PATH."products/mini/";
  $img_link     = IMAGE_PATH."products/";


require('main.view.php');
