<?php
$_OBJECTS = array(
	'user' => array(
		'description' => "The user object.",
		'methods' => array(
			'signup' => array(
				'description' => "Signup user",
				'requiredLogin' => false,
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
				'requiredLogin' => false,
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
				'requiredLogin' => true,
				'args' => array()
			),
			'checkLogin' => array(
				'description' => 'Check if the user is logged in',
				'requiredLogin' => false,
				'args' => array()
			)
		)
	),
	'recipe' => array(
		'description' => 'The recipe object',
		'methods' => array(
			'add' => array(
				'description' => "Add recipe",
				'requiredLogin' => true,
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
						'maxlen' => 10,
						'required' => true
					)
				)
			),
			'listRecipes' => array(
				'description' => 'Lists all recipes',
				'requiredLogin' => false,
				'args' => array(
					'category' => array(
						'type' => 'numeric',
						'maxLen' => 10,
						'required' => false
					)
				)
			),
			'getCatsAndAuthors' => array(
				'description' => 'Get categories and authors',
				'requiredLogin' => false,
				'args' => array()
			),
			'getAllCategories' => array(
				'description' => 'Get all categories',
				'requiredLogin' => false,
				'args' => array()
			),
			'getRecipeIngUnitsAndCats' => array(
				'description' => 'Get the recipe, the ingredients, the units and the categories',
				'requiredLogin' => false,
				'args' => array(
					'recipe' => array(
						'type' => 'numeric',
						'maxLen' => 10,
						'required' => true
					)	
				)
			),
			'getRecipeMyRecipes' => array(
				'requiredLogin' => true,
				'args' => array(
					'recipe' => array(
						'type' => 'numeric',
						'maxLen' => 10,
						'required' => true
					)
				)
			),
			'listMyRecipes' => array(
				'requiredLogin' => true,
				'args' => array()
			),
			// 'getFullRecipe' => array(
			// 	'description' => 'Get the recipe, the ingredients, the units and the categories',
			// 	'requiredLogin' => false,
			// 	'args' => array(
			// 		'recipe' => array(
			// 			'type' => 'numeric',
			// 			'maxLen' => 10,
			// 			'required' => true
			// 		)	
			// 	)
			// ),
			'edit' => array(
				'description' => 'Edit the recipe',
				'requiredLogin' => true,
				'args' => array(
					'recipe' => array(
						'type' => 'numeric',
						'maxLen' => 10,
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
				'requiredLogin' => true,
				'args' => array(
					'ingredient' => array(
						'type' => 'string',
						'maxLen' => 100,
						'required' => true
					),
					'amount' => array(
						'type' => 'numeric',
						'maxLen' => 11,
						'required' => true
					),
					'unit' => array(
						'type' => 'string',
						'maxLen' => 10,
						'required' => true
					),
					'recipe' => array(
						'type' => 'numeric',
						'maxLen' => 10,
						'required' => true
					)
				)
			),
			'remove' => array(
				'requiredLogin' => true,
				'args' => array(
					'recConId' => array(
						'type' => 'numeric',
						'maxLen' => 11,
						'required' => true
					),
					'recipe' => array(
						'type' => 'numeric',
						'maxLen' => 11,
						'required' => true
					)
				)
			),
			'update' => array(
				'requiredLogin' => true,
				'args' => array(
					'ingredient' => array(
						'type' => 'string',
						'maxLen' => 100,
						'required' => true
					),
					'amount' => array(
						'type' => 'numeric',
						'maxLen' => 11,
						'required' => true
					),
					'unit' => array(
						'type' => 'numeric',
						'maxLen' => 10,
						'required' => true
					),
					'recConId' => array(
						'type' => 'numeric',
						'maxLen' => 11,
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
				'requiredLogin' => false,
				'args' => array()
			) 
		)
	),
	'search' => array(
		'description' => 'The search object',
		'methods' => array(
			'searchAll' => array(
				'requiredLogin' => false,
				'args' => array(
					'searchStr' => array(
						'type' => 'string',
						'maxLen' => 2000,
						'required' => true
					)
				)
			)
		)
	),
	'shoppinglist' => array(
		'description' => 'The shopping list object',
		'methods' => array(
			'add' => array(
				'requiredLogin' => true,
				'args' => array(
					'recipe' => array(
						'type' => 'numeric',
						'maxLen' => 10,
						'required' => true
					)
				)
			),
			'get' => array(
				'requiredLogin' => true,
				'args' => array()
			),
			'remove' => array(
				'requiredLogin' => true,
				'args' => array(
					'itemId' => array(
						'type' => 'numeric',
						'maxLen' => 10,
						'required' => true	
					)
				)
			)
		)
	)
);
?>