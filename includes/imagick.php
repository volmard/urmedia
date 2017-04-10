<?php

//function resizeImage($imagePath, $width, $height, $filterType, $blur, $bestFit, $cropZoom)
//{
//    //The blur factor where > 1 is blurry, < 1 is sharp.
//    $imagick = new Imagick(realpath($imagePath));
// 
//    $imagick->resizeImage($width, $height, $filterType, $blur, $bestFit);
// 
//    $cropWidth = $imagick->getImageWidth();
//    $cropHeight = $imagick->getImageHeight();
// 
//    if ($cropZoom) {
//        $newWidth = $cropWidth / 2;
//        $newHeight = $cropHeight / 2;
// 
//        $imagick->cropimage(
//            $newWidth,
//            $newHeight,
//            ($cropWidth - $newWidth) / 2,
//            ($cropHeight - $newHeight) / 2
//        );
// 
//        $imagick->scaleimage(
//            $imagick->getImageWidth() * 4,
//            $imagick->getImageHeight() * 4
//        );
//    }
// 
// 
//    header("Content-Type: image/jpg");
//    echo $imagick->getImageBlob();
//}
//$imagePath = '../public/assets/images/products/hdr_1000.jpg';
//$width = 400;
//$height = 250;
//resizeImage($imagePath, $width, $height, $filterType, $blur, $bestFit, $cropZoom);

$im = new Imagick();