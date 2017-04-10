<?php
class Breadcrumbs {
	
	public static $url;
	public static $base_url;
	public static $links;	

	function __construct($home = "home") {
		self::$url      = $_SERVER['REQUEST_URI'];		
    self::$base_url = ($_SERVER['HTTPS'] ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].'/';
		self::get_links($home);
	}
	
	private static function get_links($home) {
		$parse_url                    = parse_url(self::$url, PHP_URL_PATH);	
    $path_array                   = array_filter(explode('/', $parse_url));
		$path_keys                    = array_keys($path_array);
	  $last_key                     = end($path_keys);
    self::$links[self::$base_url] = $home;
		$crumb_add = "";
    foreach ($path_array as $key => $crumb) :
      $crumb = self::clean_url($crumb);
        if ($key !== $last_key) :
		      $crumb_add                              .= $crumb."/";
          self::$links[self::$base_url.$crumb_add] = $crumb;
        else :
          self::$links[]                           = $crumb;
			  endif;
    endforeach;
	}	
	
	private static function clean_url($crumb) {
		$crumb = str_replace(['.php', '_'], ['', ' '], $crumb);
		return $crumb;
	}  
}
