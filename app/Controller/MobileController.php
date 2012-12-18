<?php

	class MobileController extends AppController
	{
		public $components = array('Session', 'Auth', 'RequestHandler');
		
		public function beforeFilter()
		{
			parent::beforeFilter();
			$this->Auth->allow('request');
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
	}
