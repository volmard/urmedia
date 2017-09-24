<?php

//dev server connection
const DB_SERVER = "localhost";
const DB_USER   = "root";
const DB_PASS   = "";
const DB_NAME   = "ecommerce";

//webhost server connection
//defined("DB_SERVER") ? null : define("DB_SERVER", "localhost");
//defined("DB_USER") ? null : define("DB_USER", "id958482_vndk");
//defined("DB_PASS") ? null : define("DB_PASS", "12qwaszx");
//defined("DB_NAME") ? null : define("DB_NAME", "id958482_ecommerce");

//global config
const TITLE     = "URMEDIA";
const LOGO      = "URMEDIA";

//dev config
$css_link       = "http://localhost/technomart/css/style.css?".time();

//main page
$main           = "index.php";
$url            = $main."?pid=";
$m_page_cat_url = $url."item&id=";
$self           = $_SERVER['REQUEST_URI']; 
$self2 = "http://localhost/technomart/public/?pid=catalog";
function paginLink($self2) {
	$newself  = strstr($self2, "&",true); 
	if(!$newself)
		$newself = $self2;
	return $newself;
};
$newself        = paginLink($self2);
$crumb_url      = $self2."&pid=";
$sort_url       = $url."catalog&sort=";


//webhost config
//$css_link  = "http://urmedia.uphero.com/assets/css/style.min.css";
//$self      = $_SERVER['REQUEST_URI'];
//
//$pos       = strpos($self, "?");  
//$newself   = substr($self, 0, $pos); 
//
//$main      = "http://urmedia.000webhostapp.com/";
//$url       = $main."?pid=";
//$crumb_url = $self."&pid=";
//$sort_url  = $url."catalog&sort=";
