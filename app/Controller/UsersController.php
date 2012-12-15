<?php

	class UsersController extends AppController
	{
		public $components = array(
			'Auth' => array(
				'authenticate' => array(
					'Form' => array(
						'fields' => array('username' => 'mail')
					)
				),
				'loginAction' => array(
					'controller' => 'users',
					'action' => 'login'
				),
				'authError' => 'Vous n\'avez pas le droit d\'accéder à cette page, veuillez vous connecter'
			)
		);

		public function beforeFilter()
		{
			parent::beforeFilter();
			$this->Auth->allow('login', 'logout', 'signup');
		}

		public function login()
		{
			if($this->Auth->user('id'))
			{
				$this->Session->setFlash('Vous êtes déjà connecté', 'flash', array('type' => 'warning'));
				$this->redirect('/');
			}

			if($this->request->is('post'))
			{
				if($this->Auth->login())
				{
					$this->Session->setFlash('Vous êtes maintenant connecté', 'flash', array('type' => 'success'));
					return $this->redirect($this->Auth->redirect());
				}
				else
				{
					$this->Session->setFlash('L\'adresse email ou le mot de passe est incorrect', 'flash', array('type' => 'error'));
				}
			}
		}

		public function logout()
		{
			$this->redirect($this->Auth->logout());
		}

		public function signup()
		{
			// Méthode d'inscription
		}
	}
