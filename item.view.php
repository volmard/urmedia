<main class="item-page">
	<ul class="breadcrumbs">
  <?php 
		foreach ($links as $link => $title) :
	  if($link) :	
	?>
	  <li class="breadcrumbs__item">
      <a href="$link"><?=$title?></a>	
  <?php 
	  else :	
	?>
	  <li class="breadcrumbs__item  breadcrumbs__item--current">
	<?php
	  echo $title;
		endif;	
	?>
	  </li>
	<?php
    endforeach;
	?>
  </ul>	
  <div class="item-page__container">
    <figure class="item-page__figure">
			<a class="item-page__img-link  item-page__img-link--big" href="<?=$img_src.$product->image?>">
				<img width="420" height="250" class="item-page__image--big" src="<?=$img_src_big.$product->image?>" alt="<?=$product->caption?>">
			</a>
			<?php
	      $i = 0;
			  foreach ($productMulti as $productSingle) :
				  if ($i > 0) :
			?>				        
			  <a class="item-page__img-link " href="<?=$img_src.$productSingle->image?>">
				  <img class="item-page__image" src="<?=$img_src_mini.$productSingle->image?>" alt="<?=$productSingle->caption?>">
				</a>
			<?php 
	     endif; 
			?>              
			<?php
			  $i++;
				endforeach;
			?>	      
    </figure>
    <section class="item-page__main-details">			
			<h2 class="item-page__item-title">
			  <span><?=$product->brandTitle?></span>
				<span><?=$product->title?></span>
			</h2>			
      <div class="item-page__quantity">
        <span>Available</span>
      </div>   
      <div class="item-page__rating-container">
        <div class="item-page__user-rating">
          <span>&#9734;</span>
          <span>&#9734;</span>
          <span>&#9734;</span>
          <span>&#9734;</span>
          <span>&#9734;</span>  
        </div>
        <a class="item-page__link" href="#">Reviews: 10</a>   
      </div>      
      <div class="item-page__item-price-container">
        <b>$<?=$product->price?></b>
        <a class="item-page__btn  item-page__btn--add" href="#">FAV</a>
        <a class="item-page__btn  item-page__btn--buy" href="<?=Cart::addLink($productSingle->id);?>">Buy</a>
      </div>
      <!--<a class="btn" href="#" >catalog</a>-->  
      <ul class="item-page__features-list">
			<?php	      
			  foreach($shortDescr as $attr => $value) :
					if($attr == $descrKeys[7]) :
					  break;
					else :
			?>		
				<li class="item-page__feature-item"><?=$attr.": ".$value?></li>
			<?php
	        endif;
	      endforeach;
			?>
      </ul>  
    </section>
    <section class="item-page__extended-details">
			<h2 class="item-page__section-title">Product Description</h2>
      <div class="item-page__description-container">
        <p class="item-page__description-text">
					<?= $product->description;?>
				</p>  
      </div>
      <table class="details-table">
        <tr class="details-table__row">
          <th>Option</th>
          <th>Description</th>
        </tr>  				
			<?php	      
			  foreach($shortDescr as $attr => $value) :
			?>
				<tr class="details-table__row">
          <td><?=$attr?></td>
          <td><?=$value?></td>
        </tr>
			<?php
	      endforeach;
			?>
      </table>
    </section> 
    <div class="item-page__reviews">          
    </div> 
  </div>  
</main>