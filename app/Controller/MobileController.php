<?php

	class MobileController extends AppController
	{
		public $components = array('Session', 'Auth', 'RequestHandler');
		
		public function beforeFilter()
		{
			parent::beforeFilter();
			$this->Auth->allow('request', 'userPlaces');
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
	}
