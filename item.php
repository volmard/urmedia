<?php 
  $breadcrumbs         = new Breadcrumbs();
  $img_src             = IMAGE_PATH."products/";
  $img_src_big         = IMAGE_PATH."products/mini/400w-";
  $img_src_mini        = IMAGE_PATH."products/mini/135w-";

  if(isset($_GET['id'])) {
		$id                = $_GET['id'];
		$product_multi     = Product::find_item_by_title($id);
		$product           = $product_multi[0];
		$short             = $product->short_description;
		$short_description = base_serialize($short, "decode");
		$description_keys  = array_keys($short_description);
	} else {
		redirect_to("/");
	}
?>
<main class="item-page">
<?php
	$result      = "<ul class=\"breadcrumbs\">";
  foreach (Breadcrumbs::$links as $link => $title) :
	  if ($link) :	
		  $result .= "<li class=\"breadcrumbs__item\">";
      $result .= "<a href=\"$link\">$title</a>";	
	  else :
	    $result .= "<li class=\"breadcrumbs__item  breadcrumbs__item--current\">";
	    $result .= $title;	
	  endif;
	  $result   .= "</li>";
  endforeach;
  $result     .= "</ul>";
  echo $result;	
?>	
  <div class="item-page__container">
    <figure class="item-page__figure">
			<a class="item-page__img-link  item-page__img-link--big" href="<?=$img_src.$product->image?>">
				<img width="420" height="250" class="item-page__image--big" src="<?=$img_src_big.$product->image?>" alt="<?=$product->caption?>">
			</a>
			<?php
	      $i = 0;
			  foreach ($product_multi as $product_single) :
				  if ($i > 0) :
			?>				        
			  <a class="item-page__img-link " href="<?=$img_src.$product_single->image?>">
				  <img class="item-page__image" src="<?=$img_src_mini.$product_single->image?>" alt="<?=$product_single->caption?>">
			<?php 
	     endif; 
			?>        
      </a>
			<?php
			  $i++;
				endforeach;
			?>	      
    </figure>
    <section class="item-page__main-details">			
			<h2 class="item-page__item-title">
			  <span><?=$product->brand_title?></span>
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
        <a class="item-page__btn  item-page__btn--add  btn" href="#">FAV</a>
        <a class="item-page__btn  item-page__btn--buy  btn" href="/catalog/<?=$product->brand_title."/".$product->title?>/?add_cart=<?=$product->id?>">Buy</a>
      </div>
      <!--<a class="btn" href="#" >catalog</a>-->  
      <ul class="item-page__features-list">
			<?php	      
			  foreach($short_description as $attr => $value) :
					if($attr == $description_keys[7]) :
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
			  foreach($short_description as $attr => $value) :
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