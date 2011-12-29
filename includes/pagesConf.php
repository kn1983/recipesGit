<?php
$_PAGES = array(
	'signup' => array(
		'loginRequired' => false
	),
	'regComplete' => array(
		'loginRequired' => false
	),
	'recipes' => array(
		'loginRequired' => false,
		'args' => array(
			'category' => array(),
			'recipe' => array(),
			'author' => array()
		)
	),
	'addRecipe' => array(
		'loginRequired' => true
	),
	'recipes' => array(
		'loginRequired' => false
	),
	'recipe' => array(
		'loginRequired' => false,
		'args' => array(
			'id' => array(
				'required' => true
			)
		)
	),
	'searchRecipes' => array(
		'loginRequired' => false
	)
);
?>