<?php

class Breadcrumbs {
	
  public static function getLinks(string $home = "home") {
	  $url     = $_SERVER['REQUEST_URI'];
		
//    $baseUrl = ($_SERVER['HTTPS'] ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].'/';
		
		/***delete on the webhost***/
    $baseUrl = 'http'.'://'.$_SERVER['HTTP_HOST'].'/';
		
		$parseUrl        = parse_url($url, PHP_URL_PATH);	
    $pathArray       = array_filter(explode('/', $parseUrl));			
		$pathKeys        = array_keys($pathArray);
	  $lastKey         = end($pathKeys);
    $links[$baseUrl] = $home;
    foreach ($pathArray as $key => $crumb) :
      $crumb = self::cleanUrl($crumb);
      if ($key !== $lastKey) :
        $links[$baseUrl.$crumb."/"] = $crumb;
      else :
        $links[]                    = $crumb;
			endif;
    endforeach;
			return $links;
	}	
	
	private static function cleanUrl(string $crumb):string {
		$crumb = str_replace(['.php', '_'], ['', ' '], $crumb);
		return $crumb;
	}
  
}