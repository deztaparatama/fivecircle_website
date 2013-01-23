<?php

	class PlacesController extends AppController
	{
		public function place($id)
		{
			$place = $this->Place->find('first', array(
				'conditions' => array('id' => $id)
			));

			if(!empty($place))
			{
				// Création de la timeline
				$this->loadModel('Visited');
				$timeline = $this->Visited->find('all', array(
					'conditions' => array('Place.id' => $id),
					'fields' => array(
						'Visited.id', 'Visited.created',
						'User.id', 'User.pseudo', 'User.name', 'User.surname', 'User.photo_name',
						'Place.id', 'Place.name'
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
			}
			else
			{
				$this->Session->setFlash('Ce lieu n\'existe pas', 'flash', array('type' => 'error'));
				$this->redirect('/');
			}

			$this->set('title_for_layout', $place['Place']['name']);
			$this->set('place', $place);
			$this->set('timeline', $timeline);
		}
	}
