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
					'ingredients' => array(
						'type' => 'array',
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