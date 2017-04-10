<?php  require_once("include/layouts/header.php");
  sidebar_navigation("brands", $brands);
?>

<? $product_set = simple_search();?>
<section class="popular container clearfix">
    <div class="popular-name popular-goods clearfix">
      <h2>Result:</h2>
      
    </div>    

    <ul class="catalog">
        <?
        while ($product = mysqli_fetch_assoc($product_set)) {
          $zoom = 4;
          list($width, $height) = getimagesize("assets/images/{$product["image"]}");  
        ?>
          <li>
            <a href="#"><img src="assets/images/<?=$product['image']?>" width="<?=$width/$zoom?>" height="<?=$height/$zoom?>" alt="<?=substr($product['image'], 0, -4)?>"></a>  
            <h3><?=$brands[$product["brand_id"]] . " " . $product["title"]?></h3>
            <a class="btn" href="#">$ <?=$product["price"]?></a>
            <div class="buy-item">          
          <a class="btn" href="add2cart.php?id=<?=$product["id"]?>">Add to cart</a>
          <a class="btn" href="urmedia.php?pid=item&id=<?=$product["id"]?>">Details</a>
        </div>  
          </li>
  
        <?}?>       

      
    </ul>
    
</section>