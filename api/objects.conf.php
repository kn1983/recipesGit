<?php
$_OBJECTS = array(
	'user' => array(
		'description' => "The user object.",
		'methods' => array(
			'signup' => array(
				'description' => "Signup user",
				'args' => array(
					'regUser' => array(
						'type' => 'string',
						'maxlen' => 100,
						'required' => true
					),
					'regPassword' => array(
						'type' => 'string',
						'maxlen' => 100,
						'required' => true
					),
					'regEmail' => array(
						'type' => 'string',
						'maxlen' => 100,
						'required' => true
					)
				)
			),
			'login' => array(
				'description' => 'Login user',
				'args' => array(
					'user' => array(
						'type' => 'string',
						'maxlen' => 100,
						'required' => true
					),
					'password' => array(
						'type' => 'string',
						'maxlen' => 100,
						'required' => true
					)
				)
			),
			'logout' => array(
				'description' => "Logout user",
				'args' => array()
			)
		)
	),
	'recipe' => array(
		'description' => 'The recipe object',
		'methods' => array(
			'add' => array(
				'description' => "Add recipe",
				'args' => array(
					'recipeTitle' => array(
						'type' => 'string',
						'maxlen' => 60,
						'required' => true
					),
					'recipeDescription' => array(
						'type' => 'string',
						'maxlen' => 2000,
						'required' => true
					),
					'portions' => array(
						'type' => 'numeric',
						'maxlen' => 10,
						'required' => true
					),
					'category' => array(
						'type' => 'numeric',
						'required' => true
					)
				)
			),
			'listRecipes' => array(
				'description' => 'Lists all recipes',
				'args' => array(
					'category' => array(
						'type' => 'numeric',
						'required' => false
					)
				)
			),
			'getCatsAndAuthors' => array(
				'description' => 'Get categories and authors',
				'args' => array()
			),
			'getAllCategories' => array(
				'description' => 'Get all categories',
				'args' => array()
			),
			'getRecipeWithIng' => array(
				'description' => 'Displays one recipe',
				'args' => array(
					'recipe' => array(
						'type' => 'numeric',
						'required' => true
					)
				)
			),
			'getRecipeIngUnitsAndCats' => array(
				'description' => 'Get the recipe, the ingredients, the units and the categories',
				'args' => array(
					'recipe' => array(
						'type' => 'numeric',
						'required' => true
					)	
				)
			),
			'edit' => array(
				'description' => 'Edit the recipe',
				'args' => array(
					'recipe' => array(
						'type' => 'numeric',
						'required' => true
					),
					'recipeTitle' => array(
						'type' => 'string',
						'maxlen' => 60,
						'required' => true
					),
					'recipeDescription' => array(
						'type' => 'string',
						'maxlen' => 2000,
						'required' => true
					),
					'portions' => array(
						'type' => 'numeric',
						'maxlen' => 10,
						'required' => true
					)
				)
			) 
		)
	),
	'ingredient' => array(
		'description' => 'The ingredient object',
		'methods' => array(
			'add' => array(
				'args' => array(
					'ingredient' => array(
						'type' => 'string',
						'required' => true
					),
					'amount' => array(
						'type' => 'numeric',
						'required' => true
					),
					'unit' => array(
						'type' => 'string',
						'required' => true
					),
					'recipe' => array(
						'type' => 'numeric',
						'required' => true
					)
				)
			),
			'remove' => array(
				'args' => array(
					'ingredient' => array(
						'type' => 'numeric',
						'required' => true
					),
					'recipe' => array(
						'type' => 'numeric',
						'required' => true
					)
				)
			),
			'update' => array(
				'args' => array(
					'ingredient' => array(
						'type' => 'string',
						'required' => true
					),
					'amount' => array(
						'type' => 'numeric',
						'required' => true
					),
					'unit' => array(
						'type' => 'numeric',
						'required' => true
					),
					'ingredientId' => array(
						'type' => 'numeric',
						'required' => true
					),
					'recipe' => array(
						'type' => 'numeric',
						'required' => true
					)
				)
			)
		)
	),
	'units' => array(
		'description' => 'Units',
		'methods' => array(
			'get' => array(
				'args' => array()
			) 
		)
	)
);
?>