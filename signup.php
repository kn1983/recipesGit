<!DOCTYPE html>
<html>
	<?php require_once 'includes/headHtml.php' ?>
	<body>
		<div id="container">
			<?php require_once 'includes/headerHtml.php'; ?>
			<div id="sidebar">Sidebar goes here</div>
			<div id="content">
				<form id="signup" action="" method="post">
					<dl>
						<dt><label for="regUser">Användarnamn</label></dt>
						<dd><input type="text" id="regUser" name="regUser" /></dd>
					</dl>
					<dl>
						<dt><label for="regPassword">Lösenord</label></dt>
						<dd><input type="password" id="regPassword" name="regPassword" /></dd>
					</dl>
					<dl>
						<dt><label for="regEmail">E-post</label></dt>
						<dd><input type="text" id="regEmail" name="regEmail" /></dd>
					</dl>
					<div class="errors">
					</div>
					<button id="signupUser">Registrera dig</button>
				</form>
			</div>
		</div>
	</body>
</html>