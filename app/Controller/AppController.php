<?php
	
	class AppController extends Controller
	{
		public $helpers = array('Session', 'Html');
		
		public $components = array('Session',
			'Auth' => array(
				'authenticate' => array(
					'Form' => array(
						'fields' => array('username' => 'pseudo')
					)
				),
				'loginAction' => array(
					'controller' => 'users',
					'action' => 'login'
				),
				'authError' => 'Pour pouvoir accéder à cette page, veuillez vous connecter',
				'logoutRedirect' => '/'
			)
		);

		public function beforeFilter()
		{
			if($this->Auth->user('status') == 1)
				$this->layout = 'user';
			else if($this->Auth->user('status') == 2)
				$this->layout = 'moderator';
		}
	}
