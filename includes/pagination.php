<?php

class Pagination {
	
	public $currentPage;
	public $perPage;
	public $totalCount;
	
	public function __construct($perPage = 20, $totalCount = 0) {
		$this->currentPage = (int) ($_GET['page'] ?? 1);
		$this->perPage     = (int) $perPage;
		$this->totalCount  = (int) $totalCount;
	}
	
	public function offset()      {
		return ($this->currentPage - 1) * $this->perPage;
	}
	
	public function totalPages()  {
		return ceil($this->totalCount/$this->perPage);
	}
	
	private function prevPage()   {
		return $this->currentPage - 1;
	}
	
	private function nextPage()   {
		return $this->currentPage + 1;
	}
	
	public function hasPrevPage() {
		return $this->prevPage() >= 1 ? $this->prevPage() : false;
	}
	
	public function hasNextPage() {
		return $this->nextPage() <= $this->totalPages() ? $this->nextPage() : false;
	}
	
	
	
	
	// @html w/ php release
	private static function prevPageItem()                      {
		global $newself;
		$prevPage = self::hasPrevPage();
		if($prevPage) {
			$result  = "<li class=\"paginator__item\">\n\t\t\t";
		  $result .= "<a class=\"paginator__link\" href=\"{$newself}&page="
		             .self::prevPage().
		             "\">prev</a>\n\t\t";
		  $result .= "</li>\n\t\t";
		  echo $result;
		} else {
			$result  = "<li class=\"paginator__item  paginator__item--disabled\">\n\t\t\t";
		  $result .= "<span class=\"paginator__link\">prev</span>\n\t\t";
		  $result .= "</li>\n\t\t";
			echo $result;
		}
	}
	
	private static function nextPageItem()                      {
		global $newself;
		$nextPage = self::hasNextPage();
		if($nextPage) {
			$result  = "<li class=\"paginator__item\">\n\t\t\t";
			$result .= "<a class=\"paginator__link\" href=\"{$newself}&page="
		              .self::nextPage().
				              "\">next</a>\n\t\t";
			
		   $result .= "</li>\n\t\t";
		  echo $result;
		} else {
			$result  = "<li class=\"paginator__item  paginator__item--disabled\">\n\t\t\t";
		  $result .= "<span class=\"paginator__link\">next</span>\n\t\t";
		  $result .= "</li>\n\t\t";
			echo $result;
		}
	}
	
	private static function pages($i=1, $page=1)                {
		global $newself;
		if($i == $page) {
			$result  = "<li class=\"paginator__item  paginator__item--current\">\n\t\t\t";
			$result .= "<a class=\"paginator__link\" href=\"{$newself}&page={$i}\">{$i}</a>\n\t\t";			
			$result .= "</li>\n\t\t";
	 	} else {
	 		$result  = "<li class=\"paginator__item\">\n\t\t\t";
			$result .= "<a class=\"paginator__link\" href=\"{$newself}&page={$i}\">{$i}</a>\n\t\t";			
			$result .= "</li>\n\t\t";
	 	} 
		echo $result;
	}
	
	private static function addPaginationLinks($visibleLinks=3) {
		for($i = self::$currentPage-$visibleLinks; $i <= self::$currentPage; $i++) {
			if($i > 0) {
		    self::pages($i, self::$currentPage);
			}
	  }			 
		for($i = self::$currentPage+1; $i <= self::totalPages(); $i++){
		  self::pages($i, self::$currentPage);
		  if($i >= self::$currentPage+$visibleLinks){
		  	break;
		  }
	  } 
	}
	
	public static function addPagination()                      {
		if(self::totalPages() > 1) {			 
			 self::prevPageItem();
			 self::addPaginationLinks();			 
			 self::nextPageItem();			 
		 }
	}
	
}