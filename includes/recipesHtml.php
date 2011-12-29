<div id="sidebar">
	<div class="categories">
		<h2>Kategorier</h2>
		<?php
			$sqlFunc = new SqlFunc();
			$categories = $sqlFunc->listCategories();
			echo "<ul>";
			while($catRow = mysql_fetch_assoc($categories)){
				echo "<li>
						<a href='index.php?page=recipes&amp;category={$catRow['id']}'>{$catRow['category']}</a>
					</li>";
			}
			echo "</ul>";
		?>
	</div>
	<div class="usersRec">
		<h2>Användares recept</h2>
		<ul>
			<li><a href="#">Berra</a></li>
			<li><a href="#">Lisa</a></li>
			<li><a href="#">Banan</a></li>
			<li><a href="#">Apa</a></li>
		</ul>
	</div>
</div>
<div id="content">
	<h2>Recept</h2>
	<div id="recipes">
		<ul>
			<?php
				$result = $sqlFunc->listRecipes();
				while($row = mysql_fetch_assoc($result)){
					echo "
						<li>
							<h3><a href=index.php?page=recipe&amp;id={$row['id']}>{$row['title']}</a></h3>
							<p>Skapat av {$row['user']}</p>
						</li>
					";
				}
			?>
		</ul>
	</div>
</div>