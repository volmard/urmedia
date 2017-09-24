<footer class="m-footer">
  <div class="m-footer__container">
    <div class="m-footer__sections-container">
      <section class="m-footer__section  m-footer__links-section">
        <h2 class="m-footer__title">urmedia</h2>
        <ul class="m-footer__list">
          <li class="m-footer__item">
						<a href="<?=$main?>">home</a>
					</li>
          <li class="m-footer__item">
						<a href="<?=$url."faq"?>">FAQ</a>
					</li>
          <li class="m-footer__item">
						<a href="<?=$url."contacts"?>">contact us</a>
					</li> 
        </ul>
      </section>
      <section class="m-footer__section  m-footer__links-section">
        <h2 class="m-footer__title">about</h2>
          <ul class="m-footer__list">
            <li class="m-footer__item">
							<a href="<?=$url."about"?>">about us</a>
						</li>
            <li class="m-footer__item">
							<a href="<?=$url."policy"?>">privacy policy</a>
						</li>
            <li class="m-footer__item">
							<a href="<?=$url."termsofservice"?>">terms of service</a>
						</li> 
          </ul>
      </section>  
      <section class="m-footer__section  m-footer__newsletter-section">       
        <form class="m-footer__newsletter-form" method="post" action="<?=$self?>">
          <label class="m-footer__label" for="subscribe">Newsletter</label>
          <p class="m-footer__text">
						Sign up to stay up-to-date and in-the-know about all things URMEDIA.
					</p>
          <div class="subscribe">
            <input id="subscribe" class="subscribe__email-input" type="email" name="subscribe-email" >
            <input class="subscribe__btn" type="submit" name="subscribe" value="subscribe">
          </div>
        </form>
      </section>
      <section class="m-footer__section  social-section">
          <h2 class="m-footer__title">LET'S BE FRIENDS</h2>
          <a target="_blank" class="social-section__btn  social-section__btn--fb" href="https://www.facebook.com/omauha"></a>
          <a target="_blank" class="social-section__btn  social-section__btn--tw" href="https://twitter.com/Omauha"></a>
          <a class="social-section__btn  social-section__btn--inst" href="#"></a>
      </section>
      </div>
      <small class="m-footer__copyright">
				
          © <?=strftime("%Y", time());?> «URMEDIA». All rights reserved<br>
				<?="PHP: ".phpversion();?>
      </small>
    </div>
  </footer>    
  <div class="modal-overlay">
  </div>
<!--  <script src="jscripts/script.js"></script>-->
</body>
</html>
<?php $database->closeConnection();?>