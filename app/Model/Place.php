<?php

	class Place extends AppModel
	{
		public $displayField = 'name';

		public $hasMany = array(
			'Visited' => array(
				'className' => 'Visited',
				'foreignKey' => 'place_id',
				'dependent' => false,
				'conditions' => '',
				'fields' => '',
				'order' => '',
				'limit' => '',
				'offset' => '',
				'exclusive' => '',
				'finderQuery' => '',
				'counterQuery' => ''
			),
			'PlaceComment' => array(
				'className' => 'PlaceComment',
				'foreignKey' => 'place_id',
				'dependent' => false,
				'conditions' => '',
				'fields' => '',
				'order' => '',
				'limit' => '',
				'offset' => '',
				'exclusive' => '',
				'finderQuery' => '',
				'counterQuery' => ''
			),
			'Mark' => array(
				'className' => 'Mark',
				'foreignKey' => 'place_id',
				'dependent' => false,
				'conditions' => '',
				'fields' => '',
				'order' => '',
				'limit' => '',
				'offset' => '',
				'exclusive' => '',
				'finderQuery' => '',
				'counterQuery' => ''
			)
		);
	}
