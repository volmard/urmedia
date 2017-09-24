<?php 
  require_once("../includes/layouts/header.php");  

  // @pagination settings
  $totalCount   = $product->countAll();
  $perPage      = 3;
  $visibleLinks = 3;
  $pagination   = new Pagination($perPage, $totalCount);
  $offset       = $pagination->offset();  	 
  $currentPage  = $pagination->currentPage;
  $totalPages   = $pagination->totalPages();
  $prevPage     = $pagination->hasPrevPage();	
  $nextPage     = $pagination->hasNextPage();
  $startPages   = $currentPage - $visibleLinks;
  $continPages  = $currentPage + 1;
  $breakPages   = $currentPage + $visibleLinks;

  // @queries settings
  $sort       = $_GET['sort']  ?? null;
  $order      = $_GET['order'] ?? null;
  $sortArray  = [$sort, $order];
  $sortLink   = $orderLink = "";
  if($sort)  $sortLink  = "&sort=".$sort;
  if($order) $orderLink = "&order=".$order;  
  $sort_url   = $url."catalog&sort=";

  if(isset($_GET['page'])) 
		$sort_url = $url."catalog&page=".$currentPage."&sort=";
	
  $arrowUrl   = $sort_url.$sortArray[0]."&order=";

  // @products settings
  $products    = $product->findAllPaginated($perPage, $offset, $sortArray);	
  
  // @breadcrumbs settings  
  $links       = Breadcrumbs::getLinks();
  $image_src   = IMAGE_PATH."products/";

require('catalog.view.php');