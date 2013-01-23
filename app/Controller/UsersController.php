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

			$friend = $this->User->Friend->find('all', array(
				'conditions' => array('user_id' => $this->Auth->user('id'), 'friend_id' => $d['User']['id'])
			));
			$this->set('isFriend', empty($friend) ? false : true);

			if($id == 0 || $id == $this->Auth->user('id'))
				$this->set('title_for_layout', 'Votre profil');
			else
				$this->set('title_for_layout', 'Profil de ' . $d['User']['pseudo']);
			$this->set('user', $d);
		}

		public function addFriend($id)
		{
			$this->loadModel('Friend');
			if($this->Friend->find('count', array(
				'conditions' => array('user_id' => $this->Auth->user('id'), 'friend_id' => $id)
			)) == 0)
			{
				$this->Friend->save(array(
					'user_id' => $this->Auth->user('id'),
					'friend_id' => $id
				), false);
			}

			$this->redirect($this->referer());
		}

		public function removeFriend($id)
		{
			$this->loadModel('Friend');
			$d = $this->Friend->find('first', array(
				'conditions' => array('user_id' => $this->Auth->user('id'), 'friend_id' => $id),
				'fields' => array('id')
			));
			if(!empty($d))
			{
				$this->Friend->delete($d['Friend']['id']);
			}

			$this->redirect($this->referer());
		}

		public function settings($id = 0)
		{
			$id = (int)$id;
			if($id == 0)
			{
				$id = $this->Auth->user('id');
			}
			else if($this->Auth->user('status') < 2)
			{
				$this->Session->setFlash('Vous ne pouvez pas accéder aux réglages des autres utilisateurs', 'flash', array('type' => 'error'));
				$this->redirect(array('controller' => 'users', 'action' => 'settings'));
			}

			$user = $this->User->find('first', array(
				'conditions' => array('id' => $id),
				'recursive' => -1
			));

			if(empty($user))
			{
				$this->Session->setFlash('Cet utilisateur n\'existe pas', 'flash', array('type' => 'error'));
				$this->redirect(array('controller' => 'users', 'action' => 'settings'));
			}

			if($this->request->is('post') || $this->request->is('put'))
			{
				if(empty($this->request->data['User']['password']))
				{
					unset($this->request->data['User']['oldPassword']);
					unset($this->request->data['User']['password']);
					unset($this->request->data['User']['password2']);
				}

				$photo = $this->request->data['User']['photo'];
				if($photo['error'] == 0)
				{
					if($photo['size'] <= 300000)
					{
						$pathinfo = pathinfo($photo['name']);
						if(in_array($pathinfo['extension'], array('jpg', 'jpeg', 'png', 'gif')))
						{
							$imagesize = getimagesize($photo['tmp_name']);
							if($imagesize[0] <= 150 && $imagesize[1] <= 150)
							{
								if(move_uploaded_file($photo['tmp_name'], 'img/users/' . $id . image_type_to_extension($imagesize[2])))
								{
									if($user['User']['photo_name'] != '0.png' &&
									   $user['User']['photo_name'] != $id . image_type_to_extension($imagesize[2]) &&
									   is_file('img/users/' . $user['User']['photo_name']))
									{
										unlink('img/users/' . $user['User']['photo_name']);
									}
									$this->request->data['User']['photo_name'] = $id . image_type_to_extension($imagesize[2]);
									unset($this->request->data['User']['photo']);
								}
								else
								{
									$this->User->validationErrors['photo'] = array('Réessayer, erreur inconnue');
									$this->Session->setFlash('Il y a une erreur avec la photo de profil', 'flash', array('type' => 'error'));
								}
							}
							else
							{
								$this->User->validationErrors['photo'] = array('L\'image est trop grande, veuillez ne pas dépasser 150*150px');
								$this->Session->setFlash('Il y a une erreur avec la photo de profil', 'flash', array('type' => 'error'));
							}
						}
						else
						{
							$this->User->validationErrors['photo'] = array('L\'image n\'a pas une bonne extension, veuillez utiliser jpg, jpeg, png ou gif');
							$this->Session->setFlash('Il y a une erreur avec la photo de profil', 'flash', array('type' => 'error'));
						}
					}
					else
					{
						$this->User->validationErrors['photo'] = array('L\'image est trop lourde, veuillez ne pas dépasser les 300Ko');
						$this->Session->setFlash('Il y a une erreur avec la photo de profil', 'flash', array('type' => 'error'));
					}
				}
				else if($photo['error'] != 4)
				{
					die('Erreur lors de l\'upload de l\'image (' . $photo['error'] . ')');
				}

				$this->User->id = $id;
				if(empty($this->User->validationErrors) && $this->User->save($this->request->data))
				{
					$this->Session->setFlash('Les modifications ont bien étés enregistrées', 'flash', array('type' => 'success'));
					$user = $this->User->find('first', array(
						'conditions' => array('id' => $id),
						'recursive' => -1
					));
				}
				else if(empty($this->User->validationErrors))
				{
					$this->Session->setFlash('Il y a une erreur dans le formulaire', 'flash', array('type' => 'error'));
				}
			}

			if($id == 0 || $id == $this->Auth->user('id'))
				$this->set('title_for_layout', 'Réglages de votre profil');
			else
				$this->set('title_for_layout', 'Réglages du profil de ' . $user['User']['pseudo']);
			
			if(empty($this->User->validationErrors))
				$this->request->data = $user;
			else
				$this->request->data['User'] += $user['User'];
		}

		public function index()
		{
			// Recherche des amis
			$user = $this->User->findById($this->Auth->user('id'));
			$friends = array();
			foreach($user['Friend'] as $v)
				$friends[] = $v['friend_id'];

			// Création de la timeline
			$this->loadModel('Visited');
			$timeline = $this->Visited->find('all', array(
				'conditions' => array('User.id' => $friends),
				'fields' => array(
					'Visited.id', 'Visited.created',
					'User.id', 'User.pseudo', 'User.name', 'User.surname',
					'Place.id', 'Place.name', 'Place.photo_name'
				),
				'order' => 'Visited.created DESC'
			));

			// Ajout des commentaires
			$this->loadModel('PlaceComment');
			foreach($timeline as $k => $v)
			{
				$timeline[$k] += $this->PlaceComment->find('first', array(
					'conditions' => array('user_id' => $v['User']['id'], 'place_id' => $v['Place']['id']),
					'fields' => array('id', 'content')
				));
			}

			// Ajout des notes
			$this->loadModel('Mark');
			foreach($timeline as $k => $v)
			{
				$timeline[$k] += $this->Mark->find('first', array(
					'conditions' => array('user_id' => $v['User']['id'], 'place_id' => $v['Place']['id']),
					'fields' => array('id', 'mark')
				));
			}

			$this->set('timeline', $timeline);
		}
	}
