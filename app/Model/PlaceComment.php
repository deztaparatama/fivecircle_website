<?php

	class PlaceComment extends AppModel
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
		
		public $hasMany = array(
			'CommentLike' => array(
				'className' => 'CommentLike',
				'foreignKey' => 'place_comment_id',
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
