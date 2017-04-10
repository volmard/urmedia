<?php 
  $samsung_items = Product::find_all_items_by_brand(1, $lim = 4, true);
  $lg_items      = Product::find_all_items_by_brand(2, $lim = 4, true);
  $img_src       = IMAGE_PATH."products/mini/";
  $img_link      = IMAGE_PATH."products/";
?>
<div class="main-page">
	<section class="brand-section">
    <div class="brand-section__wrapper">
		  <div class="brand-section__title  brand-section__title--custom  clearfix">
        <h2>Samsung Series:</h2>      
      </div>  
      <div class="brand-slider">  
        <div class="brand-slider__mask"> 
          <ul class="brand-slider__list">
          <li class="brand-slider__item">
            <div class="brand-slider__image-container">
              <img src="<?=IMAGE_PATH."qdot_colour_samsung.jpg"?>" width="400" height="250" alt="qdot_samsung">
            </div>    
            <div class="brand-slider__info-container">
              <h3 class="brand-slider__title">QUANTUM DOT COLOUR</h3>
              <p>Welcome to an incredible unrivalled world of lifelike UHD picture quality, with 64 times more colour than UHD TVs.</p> 
							<p>SUHD with Quantum Dot display changes all that by expressing an exceptionally wide range of colours, over 1 billion – breathing life into each and every one of them and giving you perfect picture quality with the most true to life colours.</p> 
							<p>This is in comparison to conventional UHD delivering 17 million colours. See the very best of new generation premium mastered content exactly as the director intended through Samsung's SUHD TV with Quantum Dot display – the reference for Hollywood studios.</p>             
            </div>
            <div class="brand-slider__tooltip">
              <h3 class="brand-slider__tooltip-title">QUANTUM DOT COLOUR</h3>
            </div>
          </li>
          <li class="brand-slider__item">
            <div class="brand-slider__image-container">
              <img src="<?=IMAGE_PATH."hdr_1000.jpg"?>" width="400" height="250" alt="hdr_1000">
            </div>    
            <div class="brand-slider__info-container">
              <h3 class="brand-slider__title">HDR 1000</h3>
              <p>The latest standard for UHD content is High Dynamic Range. All UHD TVs that are HDR compliant can display HDR content but not all HDR TVs are equal. HDR 1000 provides a far superior High Dynamic Range experience for striking brightness, exceptional shadow detail and vividly accurate colour. HDR 1000 delivers an exceptional UHD Premium viewing experience - the new generation of premium mastered content, exactly as the creator intended.
              </p>
            </div>
            <div class="brand-slider__tooltip">
              <h3 class="brand-slider__tooltip-title">HDR 1000</h3>
            </div>
          </li>
					<li class="brand-slider__item">
            <div class="brand-slider__image-container">
              <img src="<?=IMAGE_PATH."Ultra_Black_samsung.jpg"?>" width="400" height="250" alt="Ultra Black">
            </div>    
            <div class="brand-slider__info-container">
              <h3 class="brand-slider__title">Ultra Black</h3>
              <p>Enjoy striking levels of contrast even when watching TV in the brightest environments with Ultra Black Technology. Experience all the vibrant colour and detail of next generation Premium UHD without having to close the curtains or turn off the lights. This new screen technology drastically reduces ambient light reflection to ensure maximum picture contrast is delivered as the Hollywood Director intended.
              </p>
            </div>
            <div class="brand-slider__tooltip">
              <h3 class="brand-slider__tooltip-title">Ultra Black</h3>
            </div>
          </li>
					<li class="brand-slider__item">
            <div class="brand-slider__image-container">
              <img src="<?=IMAGE_PATH."smart_hub_2016.jpg"?>" width="400" height="250" alt="smart_hub_2016">
            </div>    
            <div class="brand-slider__info-container">
              <h3 class="brand-slider__title">Smart Hub</h3>
              <p>Does your TV seamlessly blend a variety of content sources? Introducing the smartest TV on the planet. Quickly access the content you want to watch from a variety of input sources on the Smart Hub home screen.</p>
							<p>Watch your favourite TV shows using the TV guide, switch to binge on UHD box sets through Netflix, Amazon Instant Video or catch up with shows you have missed through our variety of Catch Up content partners – all of this is possible without interrupting what you are currently watching and all from the Smart Hub home screen. Just 3 clicks to your favourite content
              </p>
            </div>
            <div class="brand-slider__tooltip">
              <h3 class="brand-slider__tooltip-title">Smart Hub</h3>
            </div>
          </li>
					<li class="brand-slider__item">
            <div class="brand-slider__image-container">
              <img src="<?=IMAGE_PATH."samsung_curved.jpg"?>" width="400" height="250" alt="Curved Screen">
            </div>    
            <div class="brand-slider__info-container">
              <h3 class="brand-slider__title">Curved Screen</h3>
              <p>Curves are known to please the human eye and it certainly holds true for the SUHD TV. More than just being about appearances, its curves usher in a whole world of engaging entertainment. Get pulled in to the action for a distortion-free viewing experience that’s also easy on your eyes.
              </p>
							<p>Softly and curvaceously designed, SUHD TV’s exquisitely rounded curves draw attention and elicit warm feelings. With natural curves just as we see in nature and architecture, the curved SUHD TV can be appreciated even when it’s powered off.
							</p>
            </div>
            <div class="brand-slider__tooltip">
              <h2 class="brand-slider__tooltip-title">Curved Screen</h2>
            </div>
          </li>	
        </ul>    
      </div>
    </div>  
    <div class="brand-section__bestsellers-title  clearfix">
      <h3>Bestsellers:</h3>
      <a class="brand-section__btn  btn" href="/catalog/samsung/">Samsung Series</a>
    </div>	 
    <ul class="catalog">
        <?php
          foreach ($samsung_items as $product) :					
            $id = $product->id;				  	
			  ?>				
        <li class="catalog__item">
          <div class="catalog__image-container  catalog__image-container--small">
            <img src="<?=$img_src."200w-".$product->image?>" alt="<?=$product->caption?>">
          </div>    
          <h3 class="catalog__item-title"><?= $product->brand_title . "<span> " . $product->title . "</span>"?></h3>
          <a class="catalog__item-btn  btn" href="#">$ <?=$product->price?></a>
          <div class="catalog__buy-item">                  
            <a class="catalog__cart-btn  btn" href="<?=Cart::add_link($id)?>">Add to cart</a>
            <a class="catalog__details-btn  btn" href="/catalog/<?=$product->brand_title."/".$product->title?>/"><span>Details</span></a>
          </div>  
        </li>  
        <?php
					endforeach;
			  ?>
    </ul>
  </div>
 </section>
	<section class="brand-section">
    <div class="brand-section__wrapper">
		  <div class="brand-section__title  brand-section__title--custom  clearfix">
        <h2>LG Series:</h2>      
      </div>  
      <div class="brand-slider">  
        <div class="brand-slider__mask"> 
          <ul class="brand-slider__list">
          <li class="brand-slider__item">
            <div class="brand-slider__image-container">
              <img src="<?=IMAGE_PATH."lg_10bit.jpg"?>" width="400" height="250" alt="lg_10bit">
            </div>    
            <div class="brand-slider__info-container">
              <h3 class="brand-slider__title">OLED</h3>
							<p>OLED’s unparalleled range of contrast brings shades and colours to life in a way that LED TV technology cannot match. Colour and contrast perfection.
							</p>
              <p>OLED pixels create an astonishingly accurate and wide colour range which is presented on the perfect black background only available from self emitting pixels. This combination provides the most incredible true to life colour reproduction that you have to see to believe.
              </p>
            </div>
            <div class="brand-slider__tooltip">
              <h3 class="brand-slider__tooltip-title">OLED</h3>
            </div>
          </li>
          <li class="brand-slider__item">
            <div class="brand-slider__image-container">
              <img src="<?=IMAGE_PATH."lg_4k.jpg"?>" width="400" height="250" alt="lg_4k">
            </div>    
            <div class="brand-slider__info-container">
              <h3 class="brand-slider__title">The Ultimate HDR 4K Picture</h3>
              <p>Advanced Active HDR technology can adapt to a variety of HDR formats and provides scene by scene image mastering, delivering pinpoint picture reproduction. Active HDR is better HDR.
              </p>
							<p>Television from the future. Advanced formatting technology enables LG TV to output all recognised High Dynamic Range algorithms, such as HLG, HDR 10, Dolby Vision and Technicolor. Get the HDR experience, no matter what entertainment you're enjoying.
								</p>
            </div>
            <div class="brand-slider__tooltip">
              <h3 class="brand-slider__tooltip-title">HDR 4K Picture</h3>
            </div>
          </li>
					<li class="brand-slider__item">
            <div class="brand-slider__image-container">
              <img src="<?=IMAGE_PATH."lg_ULTRA_Luminance.jpg"?>" width="400" height="250" alt="lg_ULTRA_Luminance">
            </div>    
            <div class="brand-slider__info-container">
              <h3 class="brand-slider__title">ULTRA Luminance</h3>
              <p>Expand your contrast range with ULTRA Luminance. Enjoy brighter whites and darker blacks thanks to local dimming technology which lifts the brightest scenes to brilliant new levels and the darkest shadows to life.
              </p>
            </div>
            <div class="brand-slider__tooltip">
              <h3 class="brand-slider__tooltip-title">ULTRA Luminance</h3>
            </div>
          </li>
					<li class="brand-slider__item">
            <div class="brand-slider__image-container">
              <img src="<?=IMAGE_PATH."lg_ColorPrime_Plus.jpg"?>" width="400" height="250" alt="lg_ColorPrime_Plus">
            </div>    
            <div class="brand-slider__info-container">
              <h3 class="brand-slider__title">ColourPrime Plus</h3>
              <p>ColourPrime Plus info-container an extended range of colours to express vivid images. The LG SUPER UHD TV delivers more enjoyment with a greater variety of realistic colours.
              </p>
            </div>
            <div class="brand-slider__tooltip">
              <h3 class="brand-slider__tooltip-title">ColourPrime Plus</h3>
            </div>
          </li>
					<li class="brand-slider__item">
            <div class="brand-slider__image-container">
              <img src="<?=IMAGE_PATH."lg_webOSv2.jpg"?>" width="400" height="250" alt="lg_webOS">
            </div>    
            <div class="brand-slider__info-container">
              <h3 class="brand-slider__title">webOS – The Ultimate Entertainement Pack</h3>
              <p>The award winning LG Smart TV with Freeview Play put's you in control of the entertainment on offer. Enjoy your favourite channels and catch up TV services with no monthly cost. The Smarter way of watching live TV and on demand services, with no additional devices required.
              </p>
            </div>
            <div class="brand-slider__tooltip">
              <h2 class="brand-slider__tooltip-title">webOS</h2>
            </div>
          </li>	
        </ul>    
      </div>
    </div>  
    <div class="brand-section__bestsellers-title  clearfix">
      <h3>Bestsellers:</h3>
      <a class="brand-section__btn  btn" href="catalog/lg/">LG Series</a>
    </div>
    <ul class="catalog">
        <?php
          foreach ($lg_items as $product) :
            $id = $product->id;
        ?>
        <li class="catalog__item">
          <div class="catalog__image-container  catalog__image-container--small">
            <img src="<?=$img_src."200w-".$product->image?>"  alt="<?=$product->caption?>">
          </div>    
          <h3 class="catalog__item-title"><?= $product->brand_title . "<span> " . $product->title . "</span>"?></h3>
          <a class="catalog__item-btn  btn" href="#">$ <?=$product->price?></a>
          <div class="catalog__buy-item">                  
            <a class="catalog__cart-btn  btn" href="<?=Cart::add_link($id)?>">Add to cart</a>
            <a class="catalog__details-btn  btn" href="/catalog/<?=$product->brand_title."/".$product->title?>/"><span>Details</span></a>
          </div>  
        </li>  
        <?php
					endforeach;
			  ?>
    </ul>
  </div>
 </section>
 <section class="producers">
   <div class="producers__container">        
     <h2 class="producers__title">Other brands:</h2>   
     <ul class="producers__list">
       <li class="producers__item">
         <a class="producers__link" href="#">
					 <img src="<?=IMAGE_PATH."panasonic_logo.jpg"?>" width="100"  height="15" alt="panasonic">
				 </a>
       </li>
       <li class="producers__item">
         <a class="producers__link" href="#">
					 <img src="<?=IMAGE_PATH."toshiba_logo.jpg"?>" width="100"  height="15" alt="toshiba">
				 </a>
       </li>
       <li class="producers__item">
         <a class="producers__link" href="#">
					 <img src="<?=IMAGE_PATH."sharp_logo.jpg"?>" width="100"  height="15" alt="sharp">
				 </a> 
       </li>
       <li class="producers__item">
         <a class="producers__link" href="#">
					 <img src="<?=IMAGE_PATH."vizio_logo.jpg"?>" width="100"  height="15" alt="vizio">
				 </a>
       </li>
    </ul>
  </div>
</section>   	
</div>
<section class="services">
  <div class="services__container"> 
    <h2 class="services__title">
			Services
		</h2>
    <p class="services-text">
			Let us show u what outstanding customer service is really like
		</p>
		<div class="list-slider">
      <input id="delivery" type="radio" name="list-slider" checked="">
      <label for="delivery">Shipping</label>
      <div class="list-slider__content">
        <h3 class="list-slider__title">
					Shipping
				</h3>
        <p class="list-slider__text">
					Free shipping on everything in stock!
				</p>
      </div>
			<input id="warranty" type="radio" name="list-slider">
      <label for="warranty">Warranty</label>
      <div class="list-slider__content">
        <h3 class="list-slider__title">
					Warranty
				</h3>
        <p class="list-slider__text">
					Our customers receive free tech support and a rescue service warranty
				</p>
      </div>
			<input id="credit" type="radio" name="list-slider">
      <label for="credit">Credit</label>
      <div class="list-slider__content">
        <h3 class="list-slider__title">
					credit
				</h3>
        <p class="list-slider__text">
					credit
				</p>
      </div>        
      </div>
    </div>
  </section>