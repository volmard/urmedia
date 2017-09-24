<?php 
  require_once("../includes/layouts/header.php");  

  $bid = $_GET["bid"] ?? null;

  if(!$bid)
		redirect_to("index.php?pid=catalog");
  
  // @pagination settings
  $page        = (int)($_GET['page'] ?? 1);
  $totalCount  = $product->countAll($bid);
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


  // @TODO
  // @queries settings
  $sort       = $_GET['sort']  ?? null;
  $order      = $_GET['order'] ?? null;
  $sortArray  = [$sort, $order];
  $sortLink   = $orderLink = "";
  if($sort)  $sortLink  = "&sort=".$sort;
  if($order) $orderLink = "&order=".$order;  
  $sort_url   = $url."catalog&sort=";

  // @breadcrumbs settings  
  $links       = Breadcrumbs::getLinks();

  // @ products settings
  $products    = $product->findByPaginatedBrand($perPage, $offset, $bid, true);  
  $image_src   = IMAGE_PATH."products/";

require('brands.view.php');