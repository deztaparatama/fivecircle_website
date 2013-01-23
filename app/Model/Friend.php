<?php

	class Friend extends AppModel
	{
		public $belongsTo = array(
			'User' => array(
				'className' => 'User',
				'foreignKey' => 'user_id',
				'conditions' => '',
				'fields' => '',
				'order' => ''
			),
			'FriendUser' => array(
				'className' => 'User',
				'foreignKey' => 'friend_id',
				'conditions' => '',
				'fields' => '',
				'order' => ''
			)
		);
	}
