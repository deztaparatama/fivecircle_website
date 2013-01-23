<?php

	class Mark extends AppModel
	{
		public $belongsTo = array(
			'User' => array(
				'className' => 'User',
				'foreignKey' => 'user_id',
				'conditions' => '',
				'fields' => '',
				'order' => ''
			),
			'Place' => array(
				'className' => 'Place',
				'foreignKey' => 'place_id',
				'conditions' => '',
				'fields' => '',
				'order' => ''
			)
		);
	}
