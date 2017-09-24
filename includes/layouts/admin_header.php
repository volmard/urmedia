<?php
  error_reporting(E_ALL);
  require_once("../includes/initialize.php");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title></title>    
    <link rel="stylesheet" href="../css/style.css?<?=time();?>">
  </head>
  <body class="admin-body">      
    <header class="main-header  main-header--top">
      <div class="main-header__container container">        
      </div>
    </header>
<!--
    <header class="main-header  main-header--middle">
      <div class="container clearfix">        
      </div>
    </header>
-->
    <div class="admin-page-container">
        <nav class="main-nav  main-nav--admin">
          <ul class="main-nav__list  main-nav__list--admin">
            <li class="main-nav__item  main-nav__item--admin">
              <a href="admin.php">Main</a>
            </li>
            <li class="main-nav__item  main-nav__item--admin">
              <a href="admin.php?pid=create_product">Create Product</a>
            </li>
            <li class="main-nav__item  main-nav__item--admin">
              <a href="#">Catalog</a>
            </li>
            <li class="main-nav__item  main-nav__item--admin">
              <a href="#">Brands</a>                     
            </li>
            <li class="main-nav__item  main-nav__item--admin">
              <a href="#">News</a>
            </li>
            <li class="main-nav__item  main-nav__item--admin">
              <a href="#">Sale</a>
            </li>
            <li class="main-nav__item  main-nav__item--admin">
              <a href="#">Contacts</a>
            </li>
          </ul>
        </nav>
<!--			<main class="admin-page">-->