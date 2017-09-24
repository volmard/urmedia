<main class="main-catalog">
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
    <h1 class="main-catalog__title  main__title--catalog-page">Catalog</h1>
    <form class="filter" action="#" method="post">
<!--    <h2 class="filter-title">Sort:</h2>-->
      <div class="filter__type  filter__type-by-price">
        <h2 class="filter__title">Price:</h2>
        <div class="filter__range">
          <div class="filter__line">
            <div class="filter__toggle  filter__toggle-left"></div>
            <div class="filter__toggle  filter__toggle-right"></div> 
          </div>
        </div>
        <div class="filter__inputs-container">
          <input class="filter__input" type="number" min="0" step="100" value="0">
          <span>—</span>
          <input class="filter__input" type="number" min="0" step="100" value="30000">    
        </div>
      </div>
      <div class="filter__type  filter__type-by-producers">
        <h2 class="filter__title">Brand:</h2>
          <div class="filter__controllers">
            <input id="samsung" type="checkbox" name="samsung">
            <label for="samsung">samsung</label>
            <input id="lg" type="checkbox" name="lg">
            <label for="lg">lg</label>
            <input id="sony" type="checkbox" name="sony">
            <label for="sony">sony</label>
            <input id="panasonic" type="checkbox" name="panasonic">
            <label for="panasonic">panasonic</label>
            <input id="sharp" type="checkbox" name="sharp">
            <label for="sharp">sharp</label>
          </div>
      </div>
      <div class="filter__type  filter__type-by-inch">
        <h2 class="filter__title">Size:</h2>
          <div class="filter__controllers">
            <input id="inc32" type="checkbox" name="inc32">
            <label for="inc32">32"</label>
            <input id="inc48" type="checkbox" name="inc48">
            <label for="inc48">48"</label>
            <input id="inc55" type="checkbox" name="inc55">
            <label for="inc55">55"</label>
            <input id="inc60" type="checkbox" name="inc60">
            <label for="inc60">60"</label>
          </div>
      </div>  
      <div class="filter__type  filter__type-by-3d">
        <h2 class="filter__title">3d:</h2>
          <div class="filter__controllers">
            <input id="3d-yes" type="radio" name="3d" value="3d-yes">
            <label for="3d-yes">Yes</label>
            <input id="3d-no" type="radio" name="3d" value="3d-no">
            <label for="3d-no">No</label>
          </div>
      </div>
      <a class="filter__btn  btn" href="#">Find</a>
    </form>
    <div class="main-catalog__inner-content">
      <div class="sort-filter">
        <h2 class="sort-filter__title">Sort by:</h2>
				<?php
				  if($sortArray[0] == "price") :
				?>
					<span class="sort-filter__link  sort-filter__link--active">Price</span>
				<?php
				  else :						 
				?>
				<a class="sort-filter__link" href="<?=$sort_url."price"?>">Price</a>
        <?php
				  endif;						 
				?>
				<?php
				  if($sortArray[0] == "title") :
				?>
				<span class="sort-filter__link  sort-filter__link--active">Name</span>
				<?php
				  else :						 
				?>
				<a class="sort-filter__link" href="<?=$sort_url."title"?>">Name</a>
        <?php
				  endif;						 
				?>
        <a class="sort-filter__link  sort-filter__link--disable">Rating</a>
        <a class="sort-filter__link  sort-filter__link--disable">Sells</a>
				<?php
				  if($sortArray[1] == "asc") :
				?>
					<span class="sort-filter__link  sort-filter__link--up-arrow  sort-filter__link--active">▲</span>
				<?php
				  elseif(empty($sortArray[0]) || empty($sortArray[1])) :						 
				?>
					<span class="sort-filter__link  sort-filter__link--up-arrow   sort-filter__link--active">▲</span>
				<?php
				  else :						 
				?>
				  <a class="sort-filter__link  sort-filter__link--up-arrow" href="<?=$arrowUrl."asc"?>">▲</a>
        <?php
				  endif;						 
				?>
				<?php
				  if($sortArray[1] == "desc") :
				?>
					<span class="sort-filter__link  sort-filter__link--down-arrow  sort-filter__link--active">▼</span>
				<?php
				  elseif(empty($sortArray[0])) :						 
				?>
					<span class="sort-filter__link  sort-filter__link--down-arrow  sort-filter__link--disable">▼</span>
				<?php
				  else :						 
				?>
				  <a class="sort-filter__link  sort-filter__link--down-arrow" href="<?=$arrowUrl."desc"?>">▼</a>
        <?php
				  endif;						 
				?>
      </div>         
      <ul class="catalog">
      <?php
				foreach ($products as $product) :        
          $id = $product->id;  
      ?>
				<li class="catalog__item  catalog__item--smaller-margin">
          <div class="catalog__image-container  catalog__image-container--small">						
            <img src="<?=$image_src.$product->image?>" width="200" height="130" alt="<?=$product->caption?>">
          </div>    
          <h3 class="catalog__item-title">
						<?=$product->brandTitle . " " . "<span>" . $product->title . "</span>"?>
					</h3>
          <a class="catalog__item-btn  btn" href="#">$ <?=$product->price?></a>
          <div class="catalog__buy-item">                  
            <a class="catalog__cart-btn  btn" href="<?=Cart::addLink($id)?>">Add to cart</a>
						 <a class="catalog__details-btn  btn" href="<?=$crumb_url."item&id=".$product->title?>">							
							<span>Details</span>
						</a>
          </div>  
          </li>  
        <?php
	        endforeach;
				?>
    </ul>			
    <ul class="paginator">
<!--		@previous pages-->
		<?php			
		  if($prevPage) :
		?>
			<li class="paginator__item">
		    <a class="paginator__link" href="<?="{$newself}&page=".$prevPage.$sortLink.$orderLink?>">prev</a>
		  </li>		  
		<?php
			else :
		?>	
			<li class="paginator__item  paginator__item--disabled">
		    <span class="paginator__link">prev</span>
		  </li>			
		<?php
			endif;
		?>			
<!--		@all pages-->
<!--		@part 1-->	
		<?php 			
			for($i = $startPages; $i <= $currentPage; $i++) :
			  if($i > 0) :
		?>	
		<?php 
			    if($i == $currentPage) :
		?>	
			<li class="paginator__item  paginator__item--current">
			  <a class="paginator__link" href="<?="{$newself}&page={$i}{$sortLink}{$orderLink}"?>"><?=$i?></a>			
			</li>
		<?php
	        else :
		?>	
			<li class="paginator__item ">
			  <a class="paginator__link" href="<?="{$newself}&page={$i}{$sortLink}{$orderLink}"?>"><?=$i?></a>			
			</li>
		<?php
	        endif;
			  endif; //main
		  endfor;
		?>
<!--		@part 2-->				
		<?php 
			for($i = $continPages; $i <= $totalPages; $i++) :			  
		?>	
		<?php 
			  if($i == $currentPage) :
		?>	
			<li class="paginator__item  paginator__item--current">
			  <a class="paginator__link" href="<?="{$newself}&page={$i}".$sortLink.$orderLink?>"><?=$i?></a>			
			</li>
		<?php
	      else :
		?>	
			<li class="paginator__item ">
			  <a class="paginator__link" href="<?="{$newself}&page={$i}".$sortLink.$orderLink?>"><?=$i?></a>			
			</li>
		<?php
	     endif;
			 if($i >= $breakPages) break;
		 endfor;
		?>	
<!--		@next pages-->			
		<?php		  
		  if($nextPage) :
		?>
			<li class="paginator__item">
			  <a class="paginator__link" href="<?="{$newself}&page=".$nextPage.$sortLink.$orderLink?>">next</a>	
		  </li>	
		<?php
	    else :
		?>	
			<li class="paginator__item  paginator__item--disabled">
		    <span class="paginator__link">next</span>
		  </li>
		<?php
	    endif;
		?>					
     </ul>
   </div>    
</main>