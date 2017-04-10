<?php

class Pagination {
	
	public $current_page;
	public $per_page;
	public $total_count;
	
	public function __construct($page=1, $per_page=20, $total_count=0) {
		$this->current_page = (int)$page;
		$this->per_page = (int)$per_page;
		$this->total_count = (int)$total_count;
	}
	
	public function offset() {
		return ($this->current_page - 1) * $this->per_page;
	}
	
	public function total_pages() {
		return ceil($this->total_count/$this->per_page);
	}
	
	public function previous_page() {
		return $this->current_page - 1;
	}
	
	public function next_page() {
		return $this->current_page + 1;
	}
	
	public function has_previous_page() {
		return $this->previous_page() >= 1 ? true : false;
	}
	
	public function has_next_page() {
		return $this->next_page() <= $this->total_pages() ? true : false;
	}
	
	//i dont like the html code in php
	private function previous_page_item() {
		global $self;
		$previous_page = $this->has_previous_page();
		if($previous_page) {
			$result  = "<li class=\"paginator__item\">\n\t\t\t";			
			$result .= "<a class=\"paginator__link\" href=\"{$newself}?page="
		             .$this->previous_page().
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
	
	private function next_page_item() {
		global $self;
		$next_page = $this->has_next_page();
		if($next_page) {
			$result  = "<li class=\"paginator__item\">\n\t\t\t";		  
			$result .= "<a class=\"paginator__link\" href=\"{$newself}?page="
		              .$this->next_page().
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
	
	private function pages($i=1, $page=1) {
		global $self;
		if($i == $page) {
			$result  = "<li class=\"paginator__item  paginator__item--current\">\n\t\t\t";			
			$result .= "<a class=\"paginator__link\" href=\"{$newself}?page={$i}\">{$i}</a>\n\t\t";			
			$result .= "</li>\n\t\t";
	 	} else {
	 		$result  = "<li class=\"paginator__item\">\n\t\t\t";			
			$result .= "<a class=\"paginator__link\" href=\"{$newself}?page={$i}\">{$i}</a>\n\t\t";
			$result .= "</li>\n\t\t";
	 	} 
		echo $result;
	}
	
	private function add_pagination_links($visible_links=3) {
		for($i = $this->current_page-$visible_links; $i <= $this->current_page; $i++) {
			if($i > 0) {
		    $this->pages($i, $this->current_page);
			}
	  }			 
		for($i = $this->current_page+1; $i <= $this->total_pages(); $i++){
		  $this->pages($i, $this->current_page);
		  if($i >= $this->current_page+$visible_links){
		  	break;
		  }
	  } 
	}
	
	public function add_pagination($visible_links=3) {
		if($this->total_pages() > 1) {			 
			 $this->previous_page_item();
			 $this->add_pagination_links();			 
			 $this->next_page_item();			 
		 }
	}
	
}