<?php

//server connection
defined("DB_SERVER") ? null : define("DB_SERVER", "sql313.byethost14.com");
defined("DB_USER") ? null : define("DB_USER", "b14_19893796");
defined("DB_PASS") ? null : define("DB_PASS", "!@qwaszx");
defined("DB_NAME") ? null : define("DB_NAME", "b14_19893796_ecommerce");

//dev config
$css_link  = "/assets/css/style.min.css";
$css_link  = "../../../staticmedia.byethost14.com/htdocs/assets/css/style.min.css";

//global config
$title     = "URMEDIA";
$logo      = "URMEDIA";
$self      = $_SERVER['REQUEST_URI'];
$main      = "http://urmedia.byethost14.com/";
$url       = $main."?pid=";
$crumb_url = $self."&pid=";
$sort_url  = $url."catalog&sort=";