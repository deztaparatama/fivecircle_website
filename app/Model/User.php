<?php

	class User extends AppModel
	{
		public $displayField = 'name';

		public $hasMany = array(
			'Visited' => array(
				'className' => 'Visited',
				'foreignKey' => 'user_id',
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
				'foreignKey' => 'user_id',
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
				'foreignKey' => 'user_id',
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
			'CommentLike' => array(
				'className' => 'CommentLike',
				'foreignKey' => 'user_id',
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

		public $validate = array(
			'mail' => array(
				'notEmpty' => array(
					'rule' => 'notEmpty',
					'required' => true,
					'message' => 'L\'adresse email ne doit pas être vide'
				),
				'email' => array(
					'rule' => 'email',
					'required' => true,
					'message' => 'L\'adresse email n\'a pas une forme valide'
				)
			),
			'password' => array(
				'rule' => 'notEmpty',
				'required' => true,
				'message' => 'Le mot de passe ne doit pas être vide'
			),
			'password2' => array(
				'rule' => array('sameAs', 'password'),
				'required' => true,
				'message' => 'Les mots de passes sont différents'
			)
		);

		public function sameAs($check, $other)
		{
			return $this->data['User'][$other] == array_values($check)[0];
		}

		public function beforeSave($options = array())
		{
			$this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
			return true;
		}
	}
