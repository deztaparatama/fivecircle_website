<?php
	
	class AppController extends Controller
	{
		public function beforeFilter()
		{
			if($this->Auth->user('status') == 1)
				$this->layout = 'user';
			else if($this->Auth->user('status') == 2)
				$this->layout = 'moderator';
		}
	}
