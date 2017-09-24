<?php 
  require_once("../includes/layouts/header.php");
?>
<main class="contacts-page">
  <div class="contacts-page__wrapper">       
    <h2 class="contacts-page__main-title">For general inquiries please use the following information
	  </h2>
		<form class="contacts-page__form" method="post" action="#">
      <h3 class="contacts-page__title">Leave UR message</h3>
        <label class="contacts-page__label">
          <span class="contacts-page__text">UR name:</span>
          <input class="contacts-page__input" type="text" name="username">
        </label>
        <label class="contacts-page__label">
          <span class="contacts-page__text">UR e-mail:</span>
          <input class="contacts-page__input" type="email" name="email">
        </label>
        <label class="contacts-page__label">
          <span class="contacts-page__text">UR message:</span>
          <textarea class="contacts-page__textarea" name="letter"></textarea>
        </label>          
        <input class="contacts-page__btn  btn" type="submit" value="Send">
    </form>   
    <div class="contacts-page__section-container">
      <section class="contacts-page__address-section">
        <h3 class="contacts-page__title">URMEDIA</h3>
        <p class="contacts-page__text  contacts-page__text--bottom-margin">
					51-354 Wroclaw, Poleska street
				</p>
        <div class="map-module">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2504.945936414854!2d17.02914351597536!3d51.10945764754112!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x470fc275a5a6cf57%3A0x7b0ff0a81d3b2aa0!2zUnluZWssIFdyb2PFgmF3!5e0!3m2!1sru!2spl!4v1469637050920" width="300" height="158" allowfullscreen></iframe>
          <div class="map-module__big-map">
              <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2504.945936414854!2d17.02914351597536!3d51.10945764754112!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x470fc275a5a6cf57%3A0x7b0ff0a81d3b2aa0!2zUnluZWssIFdyb2PFgmF3!5e0!3m2!1sru!2spl!4v1469637050920" width="940" height="450" allowfullscreen></iframe>
          </div>
        </div>  
      </section>
      <section class="contacts-page__hours-section">
        <h3 class="contacts-page__title">Hours</h3>
        <p class="contacts-page__text  contacts-page__text--bottom-margin">Mon-Fri: 9am-6pm</p>    
      </section>
      <section class="contacts-page__support-section">
        <h3 class="contacts-page__title">Support &amp; Questions</h3>
        <p class="contacts-page__text  contacts-page__text--bottom-margin">tel: +48 888 444 222</p>
      </section>          
    </div>        
  </div>
</main>