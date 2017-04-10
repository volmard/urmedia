<?php

defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);



$dir = realpath(__DIR__ . '/..');



defined('SITE_ROOT') ? null : define('SITE_ROOT', $dir);



defined('LIB_PATH') ? null : define('LIB_PATH', SITE_ROOT.DS.'includes');





//defined('IMAGE_PATH') ? null : define('IMAGE_PATH', "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]".'assets'.DS.'images'.DS);



//defined('IMAGE_PATH') ? null : define('IMAGE_PATH', "/assets/images/");

defined('IMAGE_PATH') ? null : define('IMAGE_PATH', "http://www.staticmedia.byethost14.com/assets/images/");



//defined('IMAGE_PATH') ? null : define('IMAGE_PATH', "http://urmedia.uphero.com/images/");





//load config file first

require_once(LIB_PATH.DS.'config.php');



//load basic functions

require_once(LIB_PATH.DS.'functions.php');



//load core objects

require_once(LIB_PATH.DS.'session.php');

require_once(LIB_PATH.DS.'database.php');

require_once(LIB_PATH.DS.'dbobject.php');

require_once(LIB_PATH.DS.'pagination.php');

require_once(LIB_PATH.DS.'breadcrumbs.php');



////load db-related classes

require_once(LIB_PATH.DS.'uploads.php');

require_once(LIB_PATH.DS.'product.php');



require_once(LIB_PATH.DS.'cart.php');

require_once(LIB_PATH.DS.'order.php');

require_once(LIB_PATH.DS.'buyer.php');

?>
