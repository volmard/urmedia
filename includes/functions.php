<?php

function placeholders($count = 0) {
	return rtrim(str_repeat('?,', $count), ',');
}

function strip_zeros_from_date($marked_string="") {  
  $no_zeros = str_replace('*0', '', $marked_string); // first remove the marked zeros
  $cleaned_string = str_replace('*', '', $no_zeros); // then remove any remaining marks
  return $cleaned_string;
}

function cleanText($text="") {  
  $no_slash     = str_replace("\'", "'", $text);
	$text_cleaned = preg_replace('/\v+|\\\r\\\n/','<br>',$no_slash);
  return $text_cleaned;
}

function redirect_to($location = NULL) {
  if ($location != NULL) {
    header("Location: {$location}");
    exit;
  }
}

function sanitizeInput($input) {
	return strip_tags(trim($input));
}

function setIds()              {
  $id = $_GET["pid"] ?? null;
	$id = strtolower(sanitizeInput($id)); 
  return $id;    
}

function output_message($message="") {
  if (!empty($message))  
    return "<p class=\"message\">{$message}</p>";  
  return "";
}

function __autoload($class_name) {
	$class_name = strtolower($class_name);
//	$path = "../includes/{$class_name}.php";
	$path = LIB_PATH.DS.$class_name.'.php';   
	if(file_exists($path)) {
		require_once($path);
	} else {
		$class_name = strtolower($class_name);
		$path = LIB_PATH.DS.$class_name.'.php'; 
		echo $path;
		die("The file {$class_name}.php could not be found.");
	}
}

function loadLayout($template = "") {
//	include(SITE_ROOT.DS.'public'.DS.'layouts'.DS.$template.'.php');
	include('../includes/layouts/'.$template);
}

function datetime_to_text($datetime="") {
  $unixdatetime = strtotime($datetime);
  return strftime("%B %d, %Y at %I:%M %p", $unixdatetime);
}

function baseSerialize($input, $method = "encode") {	
	switch($method) :
	  case 'encode':
	    return $output =  base64_encode(serialize($input));
	    break;
	  case 'decode':
	    return $output =  unserialize(base64_decode($input));
	    break;
	  default:
	    throw new Exception('Wrong method');
	endswitch;
}

function load_class($class_name) {
  $path = LIB_PATH.DS.$class_name.'.php';     
  if(file_exists($path)) {
     require_once($path); 
  }
}

function load($file_name) {
  $path = LIB_PATH.DS.$file_name.'.php';     
  if(file_exists($path)) {
     require_once($path); 
  }
}

function getSerializedData($data, &$descrKeys) {
  $shortDescr = baseSerialize($data, "decode");
  $descrKeys = array_keys($shortDescr);
	return $shortDescr;
}
	
function getIpAddress() {
  $ipKeys = array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR');
	
  foreach ($ipKeys as $key) :
    if (array_key_exists($key, $_SERVER)) :
      foreach (explode(',', $_SERVER[$key]) as $ip) :
        $ip = trim($ip);
        $ip = ip2long($ip);
        return $ip;
      endforeach;
    endif;
  endforeach;//main
	
  return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : false;
}




//will be deleted







/*good*/

  function confirm_query($result) {
    if (!$result) {
      die ("Database query failed " . 
            mysqli_connect_error() . 
            " (" . mysqli_connect_errno() . ")"         
      );
      exit;
    } 
  }
  function mysql_prep($string) {
    global $connection;
    $escaped_string = mysqli_real_escape_string($connection, $string);
    return $escaped_string;
  }
  function close_connection() {
    global $connection;  
    if (isset($connection)) {
      mysqli_close($connection);  
    }    
  }

  function add_body_class() {
      if (set_ids()) {
        $id=set_ids();  
        switch($id){ 
          case 'item': 
            $body = "item-page"; 
            break;
          case 'catalog': 
            $body = "inner-page"; 
            break;             
          default: 
            $body =""; 
        }
        $body_class=" class=\"$body\"";
      } else {
        $body_class="";
      }      
      echo $body_class;
  }    
/*else*/


  

  //search engine v0.2
  function search_item ($search, $rand, $lim) {
    global $connection;
    $query = "SELECT * FROM ";
    $query .= "products ";
    $query .= "WHERE keywords LIKE '%{$search}%'";
    if ($rand !== 0) {
      $query .= " ORDER BY RAND()";        
    }
    if ($lim !== 0) {
      $query .= " LIMIT 0, {$lim}";        
    }      
    $items_set = mysqli_query($connection, $query);
    confirm_query($items_set);
    if (mysqli_num_rows($items_set) > 0) {
      return $items_set;
    } else {
      return null;
    }      
  }
  function simple_search ($rand = 0, $lim = 0) {
     if (isset($_GET["search"]) && $_GET["search"] !== "") {
       $search = preg_replace("#[^0-9a-z]#i","",$_GET["search"]);//exam it!
       if ($search) {
         $product_set = search_item($_GET["search"], $rand, $lim);
         if (!$product_set) {
              echo "Oops, have u another ideas???";
              exit;
         }
       } else {
         echo "Oops, unpossible character";
         exit;
       }
       return $product_set;
     } else {
       echo "Please, write something at first";
       exit;        
     }      
   }
   //end of search engine
   




/*testing*/



   
/**
 * Ensures an ip address is both a valid IP and does not fall within
 * a private network range.
 */
  function validate_ip($ip) {
    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
        return false;
    }
    return true;
}


