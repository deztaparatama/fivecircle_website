<?php

	class CommentLike extends AppModel
	{
		public $belongsTo = array(
			'User' => array(
				'className' => 'User',
				'foreignKey' => 'user_id',
				'conditions' => '',
				'fields' => '',
				'order' => ''
			),
			'PlaceComment' => array(
				'className' => 'PlaceComment',
				'foreignKey' => 'place_comment_id',
				'conditions' => '',
				'fields' => '',
				'order' => ''
			)
		);
	}
