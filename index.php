<?php require_once("includes/layouts/header.php");?>

<?php

  $id=set_ids();

  switch($id){ 

    case 'item': 

      include 'item.php'; 

    break;

    case 'catalog': 

      include 'catalog.php'; 

    break;

    case 'search': 

      include 'search.php';                

    break;

		case 'brands': 

      include 'brands.php';                

    break;

		case 'cart': 

      include 'cart.php';                

    break;

		case 'orderform': 

      include 'orderform.php';                

    break;

		case 'orders': 

      include 'orders.php';                

    break;

		case 'contacts': 

      include 'contacts.php';                

    break;

		case 'news': 

      include 'news.php';                

    break;

		case 'about': 

      include 'about.php';                

    break;

		case 'faq': 

      include 'faq.php';                

    break;

		case 'policy': 

      include 'policy.php';                

    break;

		case 'termsofservice': 

      include 'terms_of_service.php';                

    break;

    default:  

      include 'main.php';    

  }

?>
<?php require_once("includes/layouts/footer.php");?>
