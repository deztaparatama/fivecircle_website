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

		public function userPlaces()
		{
			if($this->layoutPath != 'json')
				throw new NotFoundException();

			$champsManquants = array();
			if(empty($_POST['id']))
				$champsManquants[] = 'id';

			if(empty($champsManquants))
			{
				$_POST['id'] = (int)$_POST['id'];

				$this->loadModel('User');
				$user = $this->User->findById($_POST['id'], array('id', 'pseudo', 'mail', 'name', 'surname', 'date_birth', 'status', 'created'));

				if(!empty($user))
				{
					$this->loadModel('Place');
					$timeline = array();
					foreach($user['Visited'] as $k => $v)
					{
						$timeline[$k] = $this->Place->findById($v['place_id'], array('id', 'name', 'photo_name'));
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
$_POST['id'] = 1;
			$champsManquants = array();
			if(empty($_POST['id']))
				$champsManquants[] = 'id';

			if(empty($champsManquants))
			{
				$_POST['id'] = (int)$_POST['id'];

				// Recherche des amis
				$this->loadModel('User');
				$user = $this->User->findById($_POST['id']);
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

				$this->set('request', $timeline);
			}
			else
			{
				$this->set('request', array('Champs manquants' => $champsManquants));
			}

			$this->set('_serialize', 'request');
		}
	}
