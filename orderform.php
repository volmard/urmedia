<?php 

  Cart::set_cart_sum();

  if(!isset($_SESSION['summary'])) {
	  redirect_to($main);
  }

  if(isset($_POST['order'])) :
    $buyer->first_name = $_POST['first-name'];
	  $buyer->last_name  = $_POST['last-name'];
    $buyer->email      = $_POST['email'];
    $buyer->phone      = $_POST['phone'];
    $buyer->adress     = $_POST['address'];
    $buyer->ip         = get_ip_address();
    $buyer->save();
    redirect_to("index.php");
  else :	
  endif;
?>
<main class="orderform-page">
  <div class="orderform-page__container">
    <div class="orderform-page__checkout-column">
      <h1 class="orderform-page__title">CHECKOUT:</h1>
      <div class="orderform-page__acount-wrapper">
        <p class="orderform-page__text">Have an account? Sign in and save time.</p>
        <a class="orderform-page__sign-btn  btn" href="#">Sign in</a>  
      </div>   
      <form class="orderform-page__form" action="<?=$self?>" method="post">
        <section class="orderform-page__section   orderform-page__section-shipping">
          <h2 class="orderform-page__section-title">1. Shipping info</h2>
          <p class="orderform-page__text  orderform-page__text-margin">Where do you want to ship your order?</p>
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
        </section>
        <section class="orderform-page__section   orderform-page__section-payment">
          <h2 class="orderform-page__section-title">2. Payment info</h2>
          <p class="orderform-page__text">How do you want to pay?</p>
          <input class="orderform-page__payment-btn  btn" id="card-btn" type="radio" name="payment" value="credit-card">
          <label class="orderform-page__label" for="card-btn">
            Credit card        
          </label> 
          <input class="orderform-page__payment-btn  btn" id="paypal-btn" type="radio" name="payment" value="PayPal">          
          <label class="orderform-page__label" for="paypal-btn">
            PayPal
          </label>    
          <div class="orderform-page__card-container"> 
            <input class="orderform-page__input  orderform-page__input--full-width" type="number" name="card-number" placeholder="credit card number">
            <select class="orderform-page__select" name="card-type">
              <option class="orderform-page__option  orderform-page__option-disabled" selected="" disabled="" value="">
                Card type
              </option>  
              <option value="visa">
                visa  
              </option>
              <option value="mastercard">
                mastercard  
              </option>
            </select>
            <input class="orderform-page__input" type="tel" name="exp-month" maxlength="2" placeholder="exp-month">
            <input class="orderform-page__input" type="tel" name="exp-year" maxlength="4" placeholder="exp-year">
            <input class="orderform-page__input" type="tel" name="sec-code" maxlength="4" placeholder="security code">
          </div>
          <div class="orderform-page__paypal-container"> 
            <input class="orderform-page__input  orderform-page__input--full-width" type="email" name="paypal-email" placeholder="email">
          </div>
        </section>
        <input type="submit" name="order" class="order-summary__order-btn  btn" value="place order">
      </form>  
    </div>    
	  <div class="order-summary">
      <div class="order-summary__title-container">
        <h2 class="order-summary__title">Order Summary</h2>
      </div>      
      <div class="order-summary__text-container">  
        <p class="order-summary__text">
		  	  <span>Merchandise:</span>
			   <span>$<?=Cart::$sum;?></span>
		    </p>
        <p class="order-summary__text">
			    <span>Estimated Shipping:</span>
			    <span>FREE</span>
		    </p>
        <p class="order-summary__text">
			    <span>ORDER TOTAL:</span>
			    <span>$<?=Cart::$sum;?></span>
		    </p>
      </div>    
        <a class="order-summary__btn  btn" href="index.php?pid=cart">EDIT</a>
    </div>	
  </div>
</main>