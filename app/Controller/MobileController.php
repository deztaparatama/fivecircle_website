<?php

	class MobileController extends AppController
	{
		public $components = array('Session', 'Auth', 'RequestHandler');
		
		public function beforeFilter()
		{
			parent::beforeFilter();
			$this->Auth->allow();
		}

		private function sendPostValues($values)
		{
			if(is_array($values))
			{
				$ch = curl_init();
				curl_setopt_array($ch, array(
					CURLOPT_URL => 'esbackoffice.globevip.com/iota/request',
					CURLOPT_RETURNTRANSFER => true,	// Retourner le contenu téléchargé dans une chaine (au lieu de l'afficher directement)
					CURLOPT_HEADER => false,		// Ne pas inclure l'entête de réponse du serveur dans la chaine retournée
					CURLOPT_FAILONERROR => true,	// Gestion des codes d'erreur HTTP supérieurs ou égaux à 400
					CURLOPT_POST => true,			// Effectuer une requête de type POST
					CURLOPT_POSTFIELDS => $values
				));
				return curl_exec($ch);
			}
			else
			{
				return false;
			}
		}

		public function request()
		{
			if($this->layoutPath != 'json')
				throw new NotFoundException();
			/*
			// Authentification
			$auth = $this->sendPostValues(array(
				'login' => 'LOGIN',
				'passwd' => 'PASSWORD',
				'key' => '00'
			));

			// Récupération du CID
			$cid = $this->sendPostValues(array(
				'key' => $auth['...']
			));

			// Envoi de la photo
			$r = $this->sendPostValues(array(
				'data' => $_POST['photo'],
				'cid' => $cid['...'],
				'lat' => $_POST['latitude'],
				'long' => $_POST['longitude']
			));
			//*/

			// Renvoi du résultat
			$this->set('request', array(
				'idPlace' => 'test',
				'ad' => 13,
				'arazjp' => array(
					'faze' => 'f',
					'deazoi' => 'o,pfez'
				)
			));

			$this->set('_serialize', 'request');
		}

		public function login()
		{
			if($this->layoutPath != 'json')
				throw new NotFoundException();

			$champsManquants = array();
			if(empty($_POST['pseudo']))
				$champsManquants[] = 'pseudo';
			if(empty($_POST['password']))
				$champsManquants[] = 'password';

			if(empty($champsManquants))
			{
				$this->loadModel('User');
				$user = $this->User->find('first', array(
					'conditions' => array('pseudo' => $_POST['pseudo'], 'password' => AuthComponent::password($_POST['password'])),
					'fields' => 'User.id',
					'recursive' => -1
				));

				if(!empty($user))
					$id = $user['User']['id'];
				else
					$id = 0;

				$this->set('request', $id);
			}
			else
			{
				$this->set('request', array('Champs manquants' => $champsManquants));
			}

			$this->set('_serialize', 'request');
		}

		public function signup()
		{
			if($this->layoutPath != 'json')
				throw new NotFoundException();

			$champsManquants = array();
			if(empty($_POST['pseudo']))
				$champsManquants[] = 'pseudo';
			if(empty($_POST['password']))
				$champsManquants[] = 'password';
			if(empty($_POST['mail']))
				$champsManquants[] = 'mail';

			if(empty($champsManquants))
			{
				$this->loadModel('User');
				$user = $this->User->find('first', array(
					'conditions' => array(
						'OR' => array('pseudo' => $_POST['pseudo'], 'mail' => $_POST['mail'])
					),
					'recursive' => -1
				));

				if(empty($user))
				{
					$u = $this->User->save(array(
						'pseudo' => $_POST['pseudo'],
						'password' => $_POST['password'],
						'mail' => $_POST['mail']
					), false);

					$this->set('request', (!empty($u)) ? (int)$this->User->id : 0);
				}
				else
				{
					$this->set('request', ($user['User']['pseudo'] == $_POST['pseudo']) ? -1 : -2);
				}
			}
			else
			{
				$this->set('request', array('Champs manquants' => $champsManquants));
			}

			$this->set('_serialize', 'request');
		}

		public function addFriend()
		{
			if($this->layoutPath != 'json')
				throw new NotFoundException();

			$champsManquants = array();
			if(empty($_POST['id']))
				$champsManquants[] = 'id';
			if(empty($_POST['friend']))
				$champsManquants[] = 'friend';

			if(empty($champsManquants))
			{
				$this->loadModel('User');
				$user = $this->User->find('count', array(
					'conditions' => array(
						'id' => array($_POST['id'], $_POST['friend'])
					)
				));
				if($user == 2)
				{
					$this->loadModel('Friend');
					if($this->Friend->find('count', array(
						'conditions' => array('user_id' => $_POST['id'], 'friend_id' => $_POST['friend'])
					)) == 0)
					{
						$u = $this->Friend->save(array(
							'user_id' => $_POST['id'],
							'friend_id' => $_POST['friend']
						), false);
						$this->set('request', (!empty($u)) ? 0 : 1);
					}
					else
					{
						$this->set('request', 1);
					}
				}
				else
				{
					$this->set('request', 1);
				}
			}
			else
			{
				$this->set('request', array('Champs manquants' => $champsManquants));
			}

			$this->set('_serialize', 'request');
		}

		public function userPlaces()
		{
			if($this->layoutPath != 'json')
				throw new NotFoundException();

			$champsManquants = array();
			if(empty($_POST['id']))
				$champsManquants[] = 'id';
			if(empty($_POST['page']))
				$champsManquants[] = 'page';

			if(empty($champsManquants))
			{
				$_POST['id'] = (int)$_POST['id'];
				$_POST['page'] = (int)$_POST['page'];

				$this->loadModel('User');
				$user = $this->User->find('first', array(
					'conditions' => array('id' => $_POST['id']),
					'fields' => array('id', 'pseudo', 'mail', 'name', 'surname', 'date_birth', 'status', 'created'),
					'recursive' => 1
				));

				if(!empty($user))
				{
					$this->loadModel('Visited');
					$user['Visited'] = $this->Visited->find('all', array(
						'conditions' => array('user_id' => $user['User']['id']),
						'recursive' => -1,
						'limit' => 10,
						'page' => $_POST['page']
					));

					$this->loadModel('Place');
					$timeline = array();
					foreach($user['Visited'] as $k => $v)
					{
						$user['Visited'][$k] = $v = $user['Visited'][$k]['Visited'];
						$timeline[$k] = $this->Place->findById($v['place_id'], array('id', 'name', 'photo_name', 'latitude', 'longitude'));
						$timeline[$k]['date'] = $v['created'];
						foreach($user['Mark'] as $l => $w)
						{
							if($w['place_id'] == $v['place_id'])
							{
								unset($w['user_id']); unset($w['place_id']);
								$timeline[$k]['Mark'] = $w;
								unset($user['Mark'][$l]);
							}
						}
						foreach($user['PlaceComment'] as $l => $w)
						{
							if($w['place_id'] == $v['place_id'])
							{
								unset($w['user_id']); unset($w['place_id']);
								$timeline[$k]['PlaceComment'] = $w;
								unset($user['PlaceComment'][$l]);
							}
						}
					}

					$this->set('request', array('User' => $user['User'], 'Timeline' => $timeline));
				}
				else
				{
					$this->set('request', array('error' => 1));
				}
			}
			else
			{
				$this->set('request', array('Champs manquants' => $champsManquants));
			}

			$this->set('_serialize', 'request');
		}

		public function timeline()
		{
			if($this->layoutPath != 'json')
				throw new NotFoundException();

			$champsManquants = array();
			if(empty($_POST['id']))
				$champsManquants[] = 'id';
			if(empty($_POST['page']))
				$champsManquants[] = 'page';

			if(empty($champsManquants))
			{
				$_POST['id'] = (int)$_POST['id'];
				$_POST['page'] = (int)$_POST['page'];

				// Recherche des amis
				$this->loadModel('User');
				$user = $this->User->findById($_POST['id']);
				if(!empty($user))
				{
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
							'Place.id', 'Place.name', 'Place.photo_name', 'Place.latitude', 'Place.longitude'
						),
						'order' => 'Visited.created DESC',
						'limit' => 10,
						'page' => $_POST['page']
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

					$this->set('request', $timeline);
				}
				else
				{
					$this->set('request', array('error' => 1));
				}
			}
			else
			{
				$this->set('request', array('Champs manquants' => $champsManquants));
			}

			$this->set('_serialize', 'request');
		}

		public function place()
		{
			if($this->layoutPath != 'json')
				throw new NotFoundException();

			$champsManquants = array();
			if(empty($_POST['id']))
				$champsManquants[] = 'id';
			if(empty($_POST['page']))
				$champsManquants[] = 'page';

			if(empty($champsManquants))
			{
				$_POST['id'] = (int)$_POST['id'];
				$this->loadModel('Place');
				$place = $this->Place->find('first', array(
					'conditions' => array('id' => $_POST['id']),
					'recursive' => -1
				));
				if(!empty($place))
				{
					$this->loadModel('Visited');
					$place['Timeline'] = $this->Visited->find('all', array(
						'conditions' => array('place_id' => $place['Place']['id']),
						'recursive' => -1,
						'limit' => 15,
						'page' => $_POST['page']
					));

					$this->loadModel('User');
					foreach($place['Timeline'] as $k => $v)
					{
						$place['Timeline'][$k] += $this->User->find('first', array(
							'conditions' => array('id' => $v['Visited']['user_id']),
							'fields' => array('id', 'pseudo', 'name', 'surname'),
							'recursive' => -1
						));
					}

					$this->loadModel('Mark');
					foreach($place['Timeline'] as $k => $v)
					{
						$place['Timeline'][$k] += $this->Mark->find('first', array(
							'conditions' => array('place_id' => $place['Place']['id'], 'user_id' => $v['User']['id']),
							'fields' => array('id', 'mark'),
							'recursive' => -1
						));
					}

					$this->loadModel('PlaceComment');
					foreach($place['Timeline'] as $k => $v)
					{
						$place['Timeline'][$k] += $this->PlaceComment->find('first', array(
							'conditions' => array('place_id' => $place['Place']['id'], 'user_id' => $v['User']['id']),
							'fields' => array('id', 'content'),
							'recursive' => -1
						));
						if(isset($place['Timeline'][$k]['PlaceComment']))
						{
							$place['Timeline'][$k]['PlaceComment']['likes'] = $this->PlaceComment->CommentLike->find('count', array(
								'conditions' => array('place_comment_id' => $place['Timeline'][$k]['PlaceComment']['id'])
							));
						}
					}

					$this->set('request', $place);
				}
				else
				{
					$this->set('request', array('error' => 1));
				}
			}
			else
			{
				$this->set('request', array('Champs manquants' => $champsManquants));
			}

			$this->set('_serialize', 'request');
		}
	}
