<?php
  error_reporting(E_ALL);
  require_once("includes/initialize.php");    
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?=$title?></title>    
    <link rel="stylesheet" href="<?=$css_link?>">
  </head>
  <body>      
    <header class="m-header  m-header--top">
      <div class="m-header__container">
        <div class="m-header__logo">
					<a href="/"><?=$logo?></a>
				</div>
        <form class="m-header__form" action="<?=$self?>">
          <input type="search" name="search" placeholder="Search:" class="m-header__input">
          <span></span>      
        </form>
        <a class="m-header__link  m-header__link--bookmarks" href="#">
					Bookmarks:
				</a>
        <a class="m-header__link  m-header__link--cart" href="/cart/">
					URCART: <?=Cart::$amount?>
				</a>
        <a class="m-header__order-btn" href="/orderform/">Order</a>
        <div class="m-header__user-block">
          <a class="m-header__login-btn" href="#">Log in</a>
          <a class="m-header__signin-btn" href="#">Sign in</a>
        </div>
      </div>
    </header>
    <header class="m-header  m-header--middle">
      <div class="container">
        <div class="big-slider"> 					
				  <input id="slide-1" type="radio" name="slider" checked="">
          <label for="slide-1"></label>
          <a href="#">						
<!--						<img src="<?=IMAGE_PATH."banner1.jpg"?>" alt="banner1" width="1200" height="266" >-->
					</a>
          <div class="big-slider__container">
            <a class="big-slider__btn" href="#">OUR REVIEWS</a>
          </div>					
          <input id="slide-2" type="radio" name="slider">
          <label for="slide-2"></label>
          <a href="#">						
<!--						<img src="<?=IMAGE_PATH."banner2.jpg"?>" alt="banner2" width="1200" height="266" >-->
					</a>
          <div class="big-slider__container">
            <h2 class="big-slider__title">
							<a href="#">Ur journy starts here</a>
						</h2>
          </div>		
          <input id="slide-3" type="radio" name="slider">
          <label for="slide-3"></label>
          <a href="#">						
<!--						<img src="<?=IMAGE_PATH."banner3.jpg"?>" alt="banner3" width="1200" height="266" >-->
					</a>
          <div class="big-slider__container">
            <a class="big-slider__btn  big-slider__btn--inner" href="#">OUR REVIEWS</a>
          </div>				
          <div class="big-slider__controls">
            <label for="slide-1"></label>
            <label for="slide-2"></label>
            <label for="slide-3"></label>
          </div>        
        </div>
      </div>
    </header>
    <header class="m-header  m-header--bottom">
      <div class="container clearfix">
        <nav class="main-nav">
          <ul class="main-nav__list">
            <li class="main-nav__item">
              <a href="/">Main</a>
            </li>
            <li class="main-nav__item">
              <a href="/about/">Company</a>
            </li>
            <li class="main-nav__item">
              <a href="/catalog/">Catalog</a>
            </li>
            <li class="main-nav__item">
              <a href="#">Brands</a>                     
            </li>
            <li class="main-nav__item">
              <a href="/news/">News</a>
            </li>
            <li class="main-nav__item">
              <a href="#">Sale</a>
            </li>
            <li class="main-nav__item">
              <a href="/contacts/">Contacts</a>
            </li>
          </ul>
        </nav>            
      </div>
    </header>