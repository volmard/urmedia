<?php

class Images {
	
	private $ext;
	private $image;
	private $new_image;
	private $width;
	private $height;
	private $resize_width;
	private $resize_height;

	public function __construct($filename) {
		if(file_exists($filename)) :
			$this->set_image($filename);
		else :
			throw new Exception('Image ' . $filename . ' can not be found, try another image.');
		endif;
	}

	private function set_image($filename)	{
		$size      = getimagesize($filename);
		$this->ext = $size['mime'];
		switch($this->ext) :
	    case 'image/jpg':
	    case 'image/jpeg':
	      $this->image = imagecreatefromjpeg($filename);
			  break;
	    case 'image/gif':
	      $this->image = imagecreatefromgif($filename);
	      break;
	    case 'image/png':
	      $this->image = imagecreatefrompng($filename);
	      break;
	    default:
	      throw new Exception("File is not an image, please use another file type.");
	  endswitch;
	    $this->width  = imagesx($this->image);		
	    $this->height = imagesy($this->image);
	}

	public function save_image($path = null, $qlty = 10) {
	  $qlty = self::keep_range($qlty, 0, 100);
	  switch($this->ext) :
	    case 'image/jpg':
	    case 'image/jpeg':
        imageinterlace($this->new_image, true);
        imagejpeg($this->new_image, $path, $qlty);
        break;
      case 'image/gif':
	 	    imagesavealpha($this->new_image, true);
	      imagegif($this->new_image, $path, $qlty);
	      break;
      case 'image/png':
	 	   // scale quality https://github.com/szajbus/uploadpack/issues/47
	      $invert_scale_qlty = 9 - round(($img_qlty/100) * 9);		 			
        imagesavealpha($this->new_image, true);
	      imagepng($this->new_image, $path, $invert_scale_qlty);
	      break;
		  default:
        throw new Exception("Unsupported format: " . $this->ext); 
	    endswitch;
	    imagedestroy($this->new_image);
	}
	
	private static function keep_range($value, $min, $max) {
    if($value < $min) return $min;
    if($value > $max) return $max;
    return $value;
  }

	public function resize($width, $height, $resize_option = "default") {
		switch(strtolower($resize_option)) :
			case 'exact':
				$this->resize_width  = $width;
				$this->resize_height = $height;
			break;
			case 'maxwidth':
				$this->resize_width  = $width;
				$this->resize_height = $this->resize_height_by_width($width);
			break;
			case 'maxheight':
				$this->resize_width  = $this->resize_width_by_height($height);
//		$this->resize_width  = $this->width_by_height($height);
				$this->resize_height = $height;
			break;
			default:
				if($this->width > $width || $this->height > $height) :
					if ($this->width > $this->height) :
				    $this->resize_height = $this->resize_height_by_width($width);
			  		$this->resize_width  = $width;
					elseif($this->width < $this->height) :
						$this->resize_width  = $this->resize_width_by_height($height);
						$this->resize_height = $height;
					else :
						$this->resize_width  = $width;
						$this->resize_height = $height;	
					endif;
				else :
		      $this->resize_width  = $width;
		      $this->resize_height = $height;
		    endif;
			break;
		endswitch;
		$this->new_image = imagecreatetruecolor($this->resize_width, $this->resize_height);
    imagecopyresampled($this->new_image, $this->image, 0, 0, 0, 0, $this->resize_width, $this->resize_height, $this->width, $this->height);
		return $this; //Fluent interface
	}
	
	private function aspect_ratio($type = true) {
		return $type ? $this->width/$this->height : 1/($this->width/$this->height);
	}
	
	private function resize_height_by_width($width)	{
		return floor($this->aspect_ratio(false)*$width);
	}

	private function resize_width_by_height($height) {
		return floor($this->aspect_ratio()*$height);
	}	
	
	public function sharpen() {
    $sharpen = [
      [0, -1, 0],
      [-1, 5, -1],
      [0, -1, 0]
    ];
//		$sharpen = [
//      [-1.2, -1, -1.2],
//      [-1, 20, -1],
//      [-1.2, -1, -1.2]
//    ];
    $divisor = array_sum(array_map('array_sum', $sharpen));
    imageconvolution($this->new_image, $sharpen, $divisor, 0);
    return $this;  
	}

}

////Fluent interface
//try {
//	$path  = "../public/assets/images/products/";
//  $rsize = new Images($path."hdr_1000.jpg");
//  $rsize	
//	  ->resize(400, 250, 'maxwidth')
//    ->save_image($path."hdr_1000-exact.jpg", 60);
//} catch(Exception $err) {
//  echo $err->getMessage();
//}
//echo "<img src='../public/assets/images/products/hdr_1000-exact.jpg'>";
//echo "<br>";
//echo "<img src='../public/assets/images/products/hdr.jpg'>";
//echo "<br>";
//echo "<img src='../public/assets/images/products/hdr_1000.jpg'>";