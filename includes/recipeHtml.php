<div id="sidebar">
	sidebar goes here
</div>
<div id="content">
	<div id="recipe">
		<?php
		$sqlFunc = new SqlFunc();
		$recipe = $sqlFunc->getRecipe();
		$recRow = mysql_fetch_assoc($recipe);
		$ingredients = $sqlFunc->getIngredients($recRow['id']);
		echo "<h2>{$recRow['title']}</h2>
		<p class='portions'>Portioner {$recRow['portions']}</p>";
		echo "<ul>";
		while($ingRow = mysql_fetch_assoc($ingredients)){
			echo "
			<li>
				<span class='amount'>{$ingRow['amount']}</span>
				<span class='unit'>{$ingRow['unit']}</span>
				<span class='ingredient'>{$ingRow['ingredient']}</span>
			</li>";
		}
		echo "</ul>
		<p>{$recRow['description']}</p>
		";
		?>
	</div>
</div>