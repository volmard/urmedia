<?php 
  $page        = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
  $total_count = Product::count_all();
  $per_page    = 3;
  $pagination  = new Pagination($page, $per_page, $total_count);	
  $offset      = $pagination->offset();

  $sort        = $_GET['sort'] ?? null;
  $order       = $_GET['order'] ?? null;
  $sort_array  = [$sort, $order];
  $url         = $sort_array[0]."&order=";

  $products    = Product::find_with_pagination($per_page, $offset, $sort_array);	
  
  $breadcrumbs = new Breadcrumbs();
  $img_src     = IMAGE_PATH."products/mini/";
  $img_link    = IMAGE_PATH."products/";
?>
<main class="main-catalog">
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
				  if($sort_array[0] == "price") :
				?>
					<span class="sort-filter__link  sort-filter__link--active">Price</span>
				<?php
				  else :						 
				?>
				<a class="sort-filter__link" href="?sort=price">Price</a>
        <?php
				  endif;						 
				?>
				<?php
				  if($sort_array[0] == "title") :
				?>
				<span class="sort-filter__link  sort-filter__link--active">Name</span>
				<?php
				  else :						 
				?>
				<a class="sort-filter__link" href="?sort=title">Name</a>
        <?php
				  endif;						 
				?>
        <a class="sort-filter__link  sort-filter__link--disable">Rating</a>
        <a class="sort-filter__link  sort-filter__link--disable">Sells</a>
				<?php
				  if($sort_array[1] == "asc") :
				?>
					<span class="sort-filter__link  sort-filter__link--up-arrow  sort-filter__link--active">▲</span>
				<?php
				  elseif(empty($sort_array[0]) || empty($sort_array[1])) :						 
				?>
					<span class="sort-filter__link  sort-filter__link--up-arrow   sort-filter__link--active">▲</span>
				<?php
				  else :						 
				?>
				  <a class="sort-filter__link  sort-filter__link--up-arrow" href="?sort=<?=$url."asc"?>">▲</a>
        <?php
				  endif;						 
				?>
				<?php
				  if($sort_array[1] == "desc") :
				?>
					<span class="sort-filter__link  sort-filter__link--down-arrow  sort-filter__link--active">▼</span>
				<?php
				  elseif(empty($sort_array[0])) :						 
				?>
					<span class="sort-filter__link  sort-filter__link--down-arrow  sort-filter__link--disable">▼</span>
				<?php
				  else :						 
				?>
				  <a class="sort-filter__link  sort-filter__link--down-arrow" href="?sort=<?=$url."desc"?>">▼</a>
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
            <img src="<?=$img_src."200w-".$product->image?>" alt="<?=$product->caption?>">
          </div>    
          <h3 class="catalog__item-title">
						<?=$product->brand_title . " " . "<span>" . $product->title . "</span>"?>
					</h3>
          <a class="catalog__item-btn  btn" href="#">$ <?=$product->price?></a>
          <div class="catalog__buy-item">                  
            <a class="catalog__cart-btn  btn" href="/catalog/?add_cart=<?=$id?>">Add to cart</a>
						 <a class="catalog__details-btn  btn" href="/catalog/<?=$product->brand_title."/".$product->title?>/">							
							<span>Details</span>
						</a>
          </div>  
          </li>  
        <?php
	        endforeach;
				?>
    </ul>			
    <ul class="paginator">
		<?php
      $pagination->add_pagination();
    ?>			
     </ul>
    </div>    
</main>