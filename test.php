<?php

//function url($page=null) {
//  $brand_title= $product->title;
//  $title = brand_title;
//  $main  = "http://urmedia.000webhostapp.com/";
//  switch($page){ 
//    case 'catalog': 
//      $url = $main.$page.DS.$brand_title.DS.$title;
//    break;
//    default:
//      $url = $main;
//  }
//  return $url;
//}

   $self  = "test.php/?id=test";
   $pos   = strpos($self, "?");  
echo $pos;
   $new_self = substr($self, 0, $pos); 
echo $new_self;