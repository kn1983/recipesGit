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
						'required' => true
					),
					'regPassword' => array(
						'type' => 'string',
						'required' => true
					),
					'regEmail' => array(
						'type' => 'string',
						'required' => true
					)
				)
			),
			'login' => array(
				'description' => 'Login user',
				'args' => array(
					'user' => array(
						'type' => 'string',
						'required' => true
					),
					'password' => array(
						'type' => 'string',
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
						'required' => true
					),
					'recipeDescription' => array(
						'type' => 'string',
						'required' => true
					),
					'portions' => array(
						'type' => 'numeric',
						'required' => true
					),
					'ingredients' => array(
						'type' => 'array',
						'required' => true
					)
					// 'ingredients' => array(
					// 	'type' => 'array',
					// 	'required' => true,
					// 	'args' => array(
					// 		'ingredient' => array(
					// 			'type' => 'string',
					// 			'required' => true
					// 		),
					// 		'amount' => array(
					// 			'type' => 'numeric',
					// 			'required' => true
					// 		),
					// 		'unit' => array(
					// 			'type' => 'string',
					// 			'required' => true
					// 		)
					// 	)
					// )
				)
			)
		)
	),
	'ingredient' => array(
		'description' => 'The ingredient object',
		'methods' => array(
			'add' => array(
			)
		)
	)
);
?>