<?php
function __autoload($class_name){
	require_once 'classes/'. $class_name. '.class.php';
}
session_start();
$dbLogin = new DbLogin();

if(isset($_GET['page'])){
	$curPage = $_GET['page'];
} else {
	$curPage = "";
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<script type="text/javascript" src="js/jquery-1.6.4.js"></script>
		<link href="css/style.css" type="text/css" rel="stylesheet">
	</head>
	<body>
		<div id="container">
			<div id="header">
				<ul id="mainMenu">
					<li><a href="index.php">Hem</a></li>
					<li><a href="?page=signup">Registrera dig</a></li>
				</ul>
			</div>
			<?php $page = new Page($curPage); ?>
		</div>
	</body>
</html>