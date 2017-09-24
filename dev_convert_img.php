<?php
  require_once("../includes/initialize.php"); 
  $main_images   = Product::find_images();
  $path          = "assets/images/origin/products/";
  $path_to_copy   = "assets/images/products/mini/";

//main product images
  foreach ($main_images as $main_image) :
		try {	   	      
	  $rsize = new Images($path.$main_image->image);     
	  $rsize		   
		  ->resize(200, 130, 'exact')     
		  ->save_image($path_to_copy."200w-".$main_image->image, 70);
		$rsize		   
		  ->resize(400, 250, 'exact')     
		  ->save_image($path_to_copy."400w-".$main_image->image, 70);
    } catch(Exception $err) {     
	    echo $err->getMessage();     
    }   
	endforeach;


//side product images

  $dir     = "assets/images/origin/products/";
  $dir_len = strlen($dir);
  $product_imgs  = glob($dir.'*.{jpg,jpeg,png}', GLOB_BRACE);
  foreach ($product_imgs as $img) {
		if(strpos($img, "_")) {
			$prod_imgs[] = substr($img, $dir_len);
		}  	
  }
  foreach ($prod_imgs as $img) :
		try {	   	      
	  $rsize = new Images($path.$img);     
	  $rsize		   
		  ->resize(135, 115, 'default')     
		  ->save_image($path_to_copy."135w-".$img, 80);   
    } catch(Exception $err) {     
	    echo $err->getMessage();     
    }   
	endforeach;

//all images
  $all_images   = Product::find_all_images();
  $path_to_copy  = "assets/images/products/"; 
  foreach ($all_images as $image) :
    //compressing original size image
    list($width, $height) = getimagesize($path.$image->image);
    try {	   	      
	  $rsize = new Images($path.$image->image);     
	  $rsize
			->resize($width, $height, 'exact') 
		  ->save_image($path_to_copy.$image->image, 90);     
    } catch(Exception $err) {     
	    echo $err->getMessage();     
    }
	endforeach;






//main-page; news-page images
  $dir     = "assets/images/origin/";
  $dir_len = strlen($dir);
  $images  = glob($dir.'*.{jpg,jpeg,png}', GLOB_BRACE);
//  $files  = array_diff(scandir($dir), array('..', '.'));
//  $files  = array_slice(scandir($dir), 2);  
  foreach ($images as $image) {
  	$nu_images[] = substr($image, $dir_len);
  }
  $path           = "assets/images/origin/";
  $path_to_copy   = "assets/images/"; 
  foreach ($nu_images as $image) :
     list($width, $height) = getimagesize($path.$image);
		try {	   	      
	  $rsize = new Images($path.$image);	   
			if($image == "banner1.jpg") {
				$rsize		   
		      ->resize($width, $height, 'exact') 
				  ->save_image($path_to_copy.$image, 50);   
			} elseif($image == "banner2.jpg") {
				$rsize		   
		      ->resize($width, $height, 'exact') 
				  ->save_image($path_to_copy.$image, 50); 
			} elseif($image == "banner3.jpg") {
				$rsize		   
		      ->resize($width, $height, 'exact') 
				  ->save_image($path_to_copy.$image, 70);  
			} elseif($image == "lg_webOSv2.jpg" || $image == "news1.jpg") {
				$rsize		   
		      ->resize($width, $height, 'exact') 
				  ->save_image($path_to_copy.$image, 85);  
			} else {
				$rsize		   
		      ->resize($width, $height, 'exact') 
				  ->save_image($path_to_copy.$image, 85); 
			}     
    } catch(Exception $err) {     
	    echo $err->getMessage();     
    }
	endforeach;

//single conversion
  echo "<pre>";
  print_r($nu_images);
//  $image = $nu_images[4];
//  list($width, $height) = getimagesize($path.$image);
//  try {	   	      
//	  $rsize = new Images($path.$image);     
//	  $rsize		   
//		  ->resize($width, $height, 'exact')     
//		  ->save_image($path_to_copy.$image, 70);     
//    } catch(Exception $err) {     
//	    echo $err->getMessage();     
//    }

  