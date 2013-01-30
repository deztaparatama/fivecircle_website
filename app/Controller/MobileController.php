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

			$this->set('request', 3);

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

		public function deleteFriend()
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
					if($d = $this->Friend->find('first', array(
						'conditions' => array('user_id' => $_POST['id'], 'friend_id' => $_POST['friend']),
						'fields' => 'id'
					)))
					{
						$this->Friend->delete($d['Friend']['id']);
						$u = $this->Friend->find('first', array(
							'user_id' => $_POST['id'],
							'friend_id' => $_POST['friend']
						));
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

		public function friends()
		{
			if($this->layoutPath != 'json')
				throw new NotFoundException();

			$champsManquants = array();
			if(empty($_POST['id']))
				$champsManquants[] = 'id';

			if(empty($champsManquants))
			{
				$_POST['id'] = (int)$_POST['id'];

				$this->loadModel('Friend');
				$friends = $this->Friend->find('all', array(
					'conditions' => array('user_id' => $_POST['id']),
					'fields' => array('friend_id')
				));

				$this->loadModel('User');
				foreach($friends as $k => $v)
				{
					$friends[$k] += $this->User->find('first', array(
						'conditions' => array('id' => $v['Friend']['friend_id']),
						'fields' => array('id', 'pseudo', 'surname', 'name', 'photo_name'),
						'recursive' => -1
					));
					unset($friends[$k]['Friend']);
				}

				$this->set('request', $friends);
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
					'fields' => array('id', 'pseudo', 'mail', 'name', 'surname', 'date_birth', 'photo_name', 'status', 'created'),
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
						$timeline[$k] = $this->Place->find('first', array(
							'conditions' => array('id' => $v['place_id']),
							'fields' => array('id', 'name', 'photo_name', 'latitude', 'longitude'),
							'recursive' => -1
						));

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
							'User.id', 'User.pseudo', 'User.name', 'User.surname', 'User.photo_name',
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
							'fields' => array('id', 'content'),
							'recursive' => -1
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
			if(empty($_POST['user_id']))
				$champsManquants[] = 'user_id';
			if(empty($_POST['place_id']))
				$champsManquants[] = 'place_id';
			if(empty($_POST['page']))
				$champsManquants[] = 'page';

			if(empty($champsManquants))
			{
				$_POST['user_id'] = (int)$_POST['user_id'];
				$_POST['place_id'] = (int)$_POST['place_id'];

				$this->loadModel('Place');
				$place = $this->Place->find('first', array(
					'conditions' => array('id' => $_POST['place_id']),
					'recursive' => -1
				));
				if(!empty($place))
				{
					$this->loadModel('Visited');
					$place['Timeline'] = $this->Visited->find('all', array(
						'conditions' => array('place_id' => $place['Place']['id']),
						'recursive' => -1,
						'limit' => 15,
						'page' => $_POST['page'],
						'order' => 'created DESC'
					));
					$place['nbVisited'] = count($place['Timeline']);

					// Ajout des utilisateurs
					$this->loadModel('User');
					foreach($place['Timeline'] as $k => $v)
					{
						$place['Timeline'][$k] += $this->User->find('first', array(
							'conditions' => array('id' => $v['Visited']['user_id']),
							'fields' => array('id', 'pseudo', 'name', 'surname', 'photo_name'),
							'recursive' => -1
						));
					}

					// Ajout des notes
					$this->loadModel('Mark');
					$place['nbMarks'] = 0;
					$somme = 0;
					foreach($place['Timeline'] as $k => $v)
					{
						$m = $this->Mark->find('first', array(
							'conditions' => array('place_id' => $place['Place']['id'], 'user_id' => $v['User']['id']),
							'fields' => array('id', 'mark'),
							'recursive' => -1
						));
						if(!empty($m))
						{
							$place['Timeline'][$k] += $m;
							$place['nbMarks'] ++;
							$somme += $m['Mark']['mark'];
						}
					}
					$place['rating'] = ($place['nbMarks'] > 0) ? $somme / $place['nbMarks'] : -1;

					// Ajout des commentaires
					$this->loadModel('PlaceComment');
					$place['nbComments'] = 0;
					foreach($place['Timeline'] as $k => $v)
					{
						$c = $this->PlaceComment->find('first', array(
							'conditions' => array('place_id' => $place['Place']['id'], 'user_id' => $v['User']['id']),
							'fields' => array('id', 'content'),
							'recursive' => -1
						));
						if(!empty($c))
						{
							$place['Timeline'][$k] += $c;
							$place['Timeline'][$k]['PlaceComment']['likes'] = $this->PlaceComment->CommentLike->find('count', array(
								'conditions' => array('place_comment_id' => $place['Timeline'][$k]['PlaceComment']['id'])
							));
							$place['nbComments'] ++;
						}
					}

					// Tri : amis en premiers
					$this->loadModel('Friend');
					$friends = array();
					$noFriends = array();
					$place['nbFriends'] = 0;
					foreach($place['Timeline'] as $v)
					{
						if($this->Friend->find('count', array(
							'conditions' => array('user_id' => $_POST['user_id'], 'friend_id' => $v['User']['id'])
						)) == 1)
						{
							$friends[] = $v;
							$place['nbFriends'] ++;
						}
						else
						{
							$noFriends[] = $v;
						}
					}
					$place['Timeline'] = array_merge($friends,$noFriends);

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

		public function photoPlace()
		{
			if($this->layoutPath != 'json')
				throw new NotFoundException();

			$champsManquants = array();
			if(empty($_POST['id']))
				$champsManquants[] = 'id';

			if(empty($champsManquants))
			{
				$_POST['id'] = (int)$_POST['id'];
				$this->loadModel('Place');
				$place = $this->Place->find('first', array(
					'conditions' => array('id' => $_POST['id']),
					'fields' => array('photo_name'),
					'recursive' => -1
				));

				if(!empty($place))
				{
					$this->set('request', $place['Place']['photo_name']);
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

		public function namePlace()
		{
			if($this->layoutPath != 'json')
				throw new NotFoundException();

			$champsManquants = array();
			if(empty($_POST['id']))
				$champsManquants[] = 'id';

			if(empty($champsManquants))
			{
				$_POST['id'] = (int)$_POST['id'];
				$this->loadModel('Place');
				$place = $this->Place->find('first', array(
					'conditions' => array('id' => $_POST['id']),
					'fields' => array('name'),
					'recursive' => -1
				));

				if(!empty($place))
				{
					$this->set('request', $place['Place']['name']);
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

		public function newVisit()
		{
			if($this->layoutPath != 'json')
				throw new NotFoundException();

			$champsManquants = array();
			if(empty($_POST['user_id']))
				$champsManquants[] = 'user_id';
			if(empty($_POST['place_id']))
				$champsManquants[] = 'place_id';
			if(!isset($_POST['commentaire']))
				$champsManquants[] = 'commentaire';
			if(!isset($_POST['note']))
				$champsManquants[] = 'note';

			if(empty($champsManquants))
			{
				$_POST['user_id'] = (int)$_POST['user_id'];
				$_POST['place_id'] = (int)$_POST['place_id'];

				$this->loadModel('Visited');
				if($this->Visited->find('count', array(
					'conditions' => array('user_id' => $_POST['user_id'], 'place_id' => $_POST['place_id'])
				)) == 0)
				{
					$this->Visited->save(array(
						'user_id' => $_POST['user_id'],
						'place_id' => $_POST['place_id']
					), false);

					if(!empty($_POST['commentaire']))
					{
						$this->loadModel('PlaceComment');
						$this->PlaceComment->save(array(
							'user_id' => $_POST['user_id'],
							'place_id' => $_POST['place_id'],
							'content' => $_POST['commentaire']
						), false);
					}
					if(!empty($_POST['note']))
					{
						$_POST['note'] = (int)$_POST['note'];
						$this->loadModel('Mark');
						$this->Mark->save(array(
							'user_id' => $_POST['user_id'],
							'place_id' => $_POST['place_id'],
							'mark' => $_POST['note']
						), false);
					}

					$this->set('request', 1);
				}
				else
				{
					$this->set('request', 0);
				}
			}
			else
			{
				$this->set('request', array('Champs manquants' => $champsManquants));
			}

			$this->set('_serialize', 'request');
		}

		public function usersList()
		{
			if($this->layoutPath != 'json')
				throw new NotFoundException();

			$this->loadModel('User');
			$users = $this->User->find('list');

			$this->set('request', $users);
			$this->set('_serialize', 'request');
		}

		public function placesList()
		{
			if($this->layoutPath != 'json')
				throw new NotFoundException();

			$this->loadModel('Place');
			$users = $this->Place->find('list');

			$this->set('request', $users);
			$this->set('_serialize', 'request');
		}
	}
