<?php
class Page{
	private $page;
	private $requiredArgs;
	private $pages;
	function __construct($page, $pages){
		$this->page = $page;
		$this->pages = $pages;
		if($this->checkRequiredArgs()){
			$this->allowedPage();
		}
	}
	private function allowedPage(){
		if(in_array($this->page, array_keys($this->pages))){
			//Check if login is required to access the page
			if($this->pages[$this->page]['loginRequired']){
				if(isset($_SESSION['user']) && $_SESSION['user']){
					require_once "includes/" . $this->page . "Html.php";
				}
			} else {
				require_once "includes/" . $this->page . "Html.php";
			}
		}
	}
	private function checkRequiredArgs(){
		if(isset($this->pages[$this->page]['args'])){
			$args = $this->pages[$this->page]['args'];
			$validArgs = true;
			foreach($args as $key => $val){
				if($args[$key]['required'] == true){
					if(isset($_GET[$key]) && $_GET[$key] != ""){
						$validArgs = true;
					} else {
						$validArgs = false;
					}
				}
			}
			return $validArgs;
		}
		return true;
	}
}
?>