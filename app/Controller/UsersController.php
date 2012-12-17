<?php

	class UsersController extends AppController
	{
		public $helpers = array('Session', 'Html', 'Form');

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
					$this->Session->setFlash('Le pseudo ou le mot de passe est incorrect', 'flash', array('type' => 'error'));
				}
			}
		}

		public function logout()
		{
			$this->Session->setFlash('Vous êtes maintenant déconnecté', 'flash', array('type' => 'success'));
			$this->redirect($this->Auth->logout());
		}

		public function signup()
		{
			if($this->Auth->user('id'))
			{
				$this->Session->setFlash('Vous êtes déjà connecté', 'flash', array('type' => 'warning'));
				$this->redirect('/');
			}

			if($this->request->is('post'))
			{
				$this->User->set($this->request->data);
				if($this->User->validates())
				{
					if($this->User->find('count', array(
						'conditions' => array('pseudo' => $this->request->data['User']['pseudo']),
						'recursive' => -1
					)))
					{
						$this->User->validationErrors['pseudo'] = array('Ce pseudo est déjà utilisé');
						$this->Session->setFlash('Il y a des erreurs dans le formulaire', 'flash', array('type' => 'error'));
					}
					else if($this->User->save($this->request->data))
					{
						$this->Session->setFlash('Vous avez bien été inscrit, vous pouvez maintenant vous connecter', 'flash', array('type' => 'success'));
						$this->redirect(array('controller' => 'users', 'action' => 'login'));
					}
					else
					{
						$this->Session->setFlash('Il y a eu une erreur lors de l\'inscription, veuillez recommencer', 'flash', array('type' => 'error'));
					}
				}
				else
				{
					$this->Session->setFlash('Il y a des erreurs dans le formulaire', 'flash', array('type' => 'error'));
				}
			}
		}

		public function index()
		{
			// Méthode pour l'accueil de l'utilisateur
		}
	}
