<?php
class Page{
	private $page;
	function __construct($page){
		$this->page = $page;
		$this->allowedPage();
	}
	private function allowedPage(){
		require_once "includes/pagesConf.php";
		if(in_array($this->page, array_keys($_PAGES))){
			require_once "includes/" . $this->page . "Html.php";
		}
	}
}
?>