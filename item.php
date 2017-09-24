<?php 
  require_once("../includes/layouts/header.php");

  // @ breadcrumbs settings
  $links         = Breadcrumbs::getLinks();;
  $img_src       = IMAGE_PATH."products/";
  $img_src_big   = IMAGE_PATH."products/mini/400w-";
  $img_src_mini  = IMAGE_PATH."products/mini/135w-";


  // @ product settings

  $id = $_GET['id'] ?? null;

  if($id) :
		$id           = sanitizeInput($id);
		$productMulti = $product->findItemByTitle($id);
		$product      = $productMulti[0];
		$shortDescr   = getSerializedData($product->shortDescription, $descrKeys);
	else :
		redirect_to("index.php");
	endif;


  // @ load view template
require('item.view.php');