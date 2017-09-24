<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?=TITLE?></title>    
    <link rel="stylesheet" href="<?=$css_link?>">		
    <style>
	    .login-popup {
	    	background: rgba(0,0,0,.25);
	    	padding: 20px 25px 0 25px;
	    	position: fixed;
	    	left: 50%;
	    	transform: translate(-200px);
	    	top:  120px;
	    	width: 400px;
	    	z-index: 5;		
				animation-name: popup;
				animation-duration: 1s;
	    }
			@keyframes popup {
				0%   {top:  0px;}
				80% {top:  120px;}
				100% {top:  120px;}
			}
		</style>	
  </head>
  <body>      
    <header class="m-header  m-header--top">
      <div class="m-header__container">
        <div class="m-header__logo">
					<a href="index.php"><?=LOGO?></a>
				</div>
        <form class="m-header__form" action="<?=$self?>">
          <input type="search" name="search" placeholder="Search:" class="m-header__input">
          <span></span>      
        </form>
        <a class="m-header__link  m-header__link--bookmarks" href="#">
					Bookmarks:
				</a>
        <a class="m-header__link  m-header__link--cart" href="<?=$url."cart"?>">
					URCART: <?=Cart::$amount?>
				</a>
        <div class="m-header__user-block">
					
				<?php
	        if($session->isLoggedIn()) :
				?>
				  <a class="m-header__signin-btn" href="#"><?=$session->userLogin;?> logged</a>
					<a class="m-header__signin-btn" href="<?=$url."logout"?>">Logout</a>	
				<?php
	        elseif(isset($_GET['pid'])) :
				?>			 
          <a class="m-header__login-btn" href="<?=$_SERVER['REQUEST_URI']."&lid=login"?>">Log in</a>
          <a class="m-header__signin-btn" href="<?=$_SERVER['REQUEST_URI']."&lid=signin"?>">Sign in</a>								
				<?php
	        else :							 
				?>	
				  <a class="m-header__login-btn" href="<?=$url."login"?>">Log in</a>
          <a class="m-header__signin-btn" href="<?=$url."signin"?>">Sign in</a>					
				<?php
	        endif;
				?>				    

				<?php					
				  if(isset($_GET['pid']) && $_GET['pid'] == 'signin' || isset($_GET['lid']) && $_GET['lid'] == 'signin') :			
			  ?>
        <form class="orderform-page__form login-popup" action="<?=$self?>" method="post">
          <section class="orderform-page__section   orderform-page__section-shipping">							
            <select class="orderform-page__select  orderform-page__input--full-width" name="countries">  
            <option value="US">
              United States
            </option>
						<option value="CA">
              Canada
            </option>
            <option value="APO/FPO/DPO">
              APO/FPO/DPO
            </option>
        <option value="AD">
          Andorra
        </option>
        <option value="AR">
          Argentina
        </option>
        <option value="AU">
          Australia
        </option>
        <option value="AT">
          Austria
        </option>
        <option value="BS">
          Bahamas
        </option>
        <option value="BB">
          Barbados
        </option>
        <option value="BE">
          Belgium
        </option>
        <option value="BZ">
          Belize
        </option>
        <option value="BM">
          Bermuda
        </option>
        <option value="BO">
          Bolivia
        </option>
        <option value="BA">
          Bosnia &amp; Herzegovina
        </option>
        <option value="BR">
          Brazil
        </option>
        <option value="VG">
          British Virgin Islands
        </option>
        <option value="BG">
          Bulgaria
        </option>
        <option value="KY">
          Cayman Islands
        </option>
        <option value="CL">
          Chile
        </option>
        <option value="CN">
          China
        </option>
        <option value="CO">
          Colombia
        </option>
        <option value="CR">
          Costa Rica
        </option>
        <option value="HR">
          Croatia
        </option>
        <option value="CZ">
          Czech Republic
        </option>
        <option value="DK">
          Denmark
        </option>
        <option value="DM">
          Dominica
        </option>
        <option value="DO">
          Dominican Republic
        </option>
        <option value="EC">
          Ecuador
        </option>
        <option value="EG">
          Egypt
        </option>
        <option value="SV">
          El Salvador
        </option>
        <option value="FI">
          Finland
        </option>
        <option value="FR">
          France
        </option>
        <option value="DE">
          Germany
        </option>
        <option value="GR">
          Greece
        </option>
        <option value="GL">
          Greenland
        </option>
        <option value="GT">
          Guatemala
        </option>
        <option value="GG">
          Guernsey
        </option>
        <option value="HN">
          Honduras
        </option>
        <option value="HK">
          Hong Kong
        </option>
        <option value="HU">
          Hungary
        </option>
        <option value="IS">
          Iceland
        </option>
        <option value="IN">
          India
        </option>
        <option value="ID">
          Indonesia
        </option>
        <option value="IE">
          Ireland
        </option>
        <option value="IL">
          Israel
        </option>
        <option value="IM">
          Isle of Man
        </option>
        <option value="IT">
          Italy
        </option>
        <option value="JM">
          Jamaica
        </option>
        <option value="JP">
          Japan
        </option>
        <option value="JE">
          Jersey
        </option>
        <option value="LU">
          Luxembourg
        </option>
        <option value="MX">
          Mexico
        </option>
        <option value="MQ">
          Martinique
        </option>
        <option value="MC">
          Monaco
        </option>
        <option value="NL">
          Netherlands
        </option>
        <option value="NZ">
          New Zealand
        </option>
        <option value="NI">
          Nicaragua
        </option>
        <option value="NO">
          Norway
        </option>
        <option value="PA">
          Panama
        </option>
        <option value="PG">
          Papua New Guinea
        </option>
        <option value="PE">
          Peru
        </option>
        <option value="PH">
          Philippines
        </option>
        <option value="PL">
          Poland
        </option>
        <option value="PT">
          Portugal
        </option>
        <option value="RO">
          Romania
        </option>
        <option value="RU">
          Russia
        </option>
        <option value="KN">
          Saint Kitts &amp; Nevis
        </option>
        <option value="SG">
          Singapore
        </option>
        <option value="SI">
          Slovenia
        </option>
        <option value="ZA">
          South Africa
        </option>
        <option value="KR">
          South Korea
        </option>
        <option value="ES">
          Spain
        </option>
        <option value="SE">
          Sweden
        </option>
        <option value="CH">
          Switzerland
        </option>
        <option value="TW">
          Taiwan
        </option>
        <option value="TH">
          Thailand
        </option>
        <option value="TT">
          Trinidad &amp; Tobago
        </option>
        <option value="TR">
          Turkey
        </option>
        <option value="AE">
          United Arab Emirates
        </option>
        <option value="GB">
          United Kingdom
        </option>
        <option value="UY">
          Uruguay
        </option>
        <option value="VE">
          Venezuela
        </option>   
     </select>
            <input class="orderform-page__input  orderform-page__input--half-width" type="text" name="first-name" placeholder="first name">			
            <input class="orderform-page__input  orderform-page__input--half-width" type="text" name="last-name" placeholder="last name">
	          <input class="orderform-page__input  orderform-page__input--full-width" type="text" name="address" placeholder="adress">
            <input class="orderform-page__input  orderform-page__input--half-width" type="email" name="email" placeholder="email">
	          <input class="orderform-page__input  orderform-page__input--half-width" type="number" name="phone" placeholder="phone"> 
					  <input class="orderform-page__input  orderform-page__input--full-width" type="text" name="login" placeholder="login">
						<input class="orderform-page__input  orderform-page__input--full-width" type="password" name="password" placeholder="password">
						<input class="order-summary__order-btn  btn" type="submit" name="signin" value="signin">
          </section>
				</form>
				<?php
          endif;								
				?>	
				<?php
				  if(isset($_GET['lid']) && $_GET['lid'] == 'login' || isset($_GET['pid']) && $_GET['pid'] == 'login') :	
				?>
        <form class="orderform-page__form login-popup" action="<?=$self?>" method="post">
          <section class="orderform-page__section   orderform-page__section-shipping">
 					  <input class="orderform-page__input  orderform-page__input--full-width" type="text" name="login" placeholder="login">
						<input class="orderform-page__input  orderform-page__input--full-width" type="password" name="password" placeholder="password">
						<input class="order-summary__order-btn  btn" type="submit" name="login-btn" value="login">
          </section>
					</form>					
				<?php
          endif;								
				?>	
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
              <a href="<?=$main?>">Main</a>
            </li>
            <li class="main-nav__item">
              <a href="<?=$url."about"?>">Company</a>
            </li>
            <li class="main-nav__item">
              <a href="<?=$url."catalog"?>">Catalog</a>
            </li>
            <li class="main-nav__item">
              <a href="#">Brands</a>                     
            </li>
            <li class="main-nav__item">
              <a href="<?=$url."news"?>">News</a>
            </li>
            <li class="main-nav__item">
              <a href="#">Sale</a>
            </li>
            <li class="main-nav__item">
              <a href="<?=$url."contacts"?>">Contacts</a>
            </li>
          </ul>
        </nav>            
      </div>
    </header>