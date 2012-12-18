<?php

	class UsersController extends AppController
	{
		public $helpers = array('Session', 'Html', 'Form', 'Date');

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

		public function profile($id = 0)
		{
			$id = (int)$id;
			if($id == 0)
				$idUser = $this->Auth->user('id');
			else
				$idUser = $id;

			$d = $this->User->find('first', array(
				'conditions' => array('id' => $idUser),
				'recursive' => -1
			));

			if(empty($d))
			{
				$this->Session->setFlash('Ce membre n\'existe pas', 'flash', array('type' => 'error'));
				$this->redirect(array('controller' => 'users', 'action' => 'profile'));
			}

			if($id == 0 || $id == $this->Auth->user('id'))
				$this->set('title_for_layout', 'Votre profil');
			else
				$this->set('title_for_layout', 'Profil de ' . $d['User']['pseudo']);
			$this->set('user', $d);
		}

		public function settings($id = 0)
		{
			$id = (int)$id;
			if($id == 0)
				$idUser = $this->Auth->user('id');
			else if($this->Auth->user('status') >= 2)
				$idUser = $id;
			else
			{
				$this->Session->setFlash('Vous ne pouvez pas accéder aux réglages des autres utilisateurs', 'flash', array('type' => 'error'));
				$this->redirect(array('controller' => 'users', 'action' => 'settings'));
			}

			if(!empty($this->request->data))
			{
				$this->Session->setFlash('Héhé ! Ça ne marche pas encore ... mais les erreurs ci-dessous sont tout à fait normales ;)', 'flash', array('type' => 'warning'));
			}
			else
			{
				$this->data = $this->User->find('first', array(
					'conditions' => array('id' => $idUser),
					'recursive' => -1
				));
			}

			if(empty($this->data))
			{
				$this->Session->setFlash('Ce membre n\'existe pas', 'flash', array('type' => 'error'));
				$this->redirect(array('controller' => 'users', 'action' => 'settings'));
			}

			if($id == 0 || $id == $this->Auth->user('id'))
				$this->set('title_for_layout', 'Réglages de votre profil');
			else
				$this->set('title_for_layout', 'Réglages du profil de ' . $this->data['User']['pseudo']);
		}

		public function index()
		{
			// Méthode pour l'accueil de l'utilisateur
		}
	}
