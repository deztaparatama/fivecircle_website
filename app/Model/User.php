<?php

	class User extends AppModel
	{
		public $displayField = 'name';

		public $hasMany = array(
			'Friend' => array(
				'className' => 'Friend',
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
			'pseudo' => array(
				'rule' => 'notEmpty',
				'required' => true,
				'message' => 'Le pseudo ne doit pas être vide',
				'on' => 'create'
			),
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
				'message' => 'Le mot de passe ne doit pas être vide',
				'on' => 'create'
			),
			'password2' => array(
				'rule' => array('sameAs', 'password'),
				'required' => true,
				'message' => 'Les mots de passes sont différents',
				'on' => 'create'
			)
		);

		public function sameAs($check, $other)
		{
			$value = array_values($check);
			$value = $value[0];
			return $this->data['User'][$other] == $value;
		}

		public function beforeSave($options = array())
		{
			if(isset($this->data['User']['password']))
				$this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
			if(isset($this->data['User']['date_birth']))
			{
				// PAS TROP TOP ÇA ...
				$elems = explode(' ', $this->data['User']['date_birth']);
				$mois = array('Janvier' => '01', 'Février' => '02', 'Mars' => '03', 'Avril' => '04', 'Mai' => '05', 'Juin' => '06', 'Juillet' => '07', 'Août' => '08', 'Septembre' => '09', 'Octobre' => '10', 'Novembre' => '11', 'Décembre' => '12');
				$this->data['User']['date_birth'] = $elems[0] . '-' . $mois[$elems[1]] . '-' . $elems[2];
			}
			
			return true;
		}
	}
