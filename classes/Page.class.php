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
			
			//Check if login is required to access the page
			if($_PAGES[$this->page]['loginRequired']){
				if(isset($_SESSION['user']) && $_SESSION['user']){
					require_once "includes/" . $this->page . "Html.php";
				}
			} else {
				require_once "includes/" . $this->page . "Html.php";
			}
		}
	}
}
?>