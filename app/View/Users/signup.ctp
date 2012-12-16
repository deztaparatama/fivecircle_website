<?php

	$this->start('style'); ?>
		body
		{
			background-color: #f5f5f5;
		}
	<?php $this->end();

	$this->assign('title', 'Inscription');

?>

<?php echo $this->Form->create('User', array(
	'class' => 'form-signin',
	'inputDefaults' => array(
		'label' => false,
		'div' => false,
		'class' => 'input-block-level'
	)
)); ?>
	
	<h2 class="form-signin-heading">Inscrivez-vous !</h2>

	<?php
		
		if($this->Form->isFieldError('mail'))
			echo $this->Form->input('mail', array('placeholder' => 'Adresse email', 'div' => 'control-group error'));
		else
			echo $this->Form->input('mail', array('placeholder' => 'Adresse email'));

		if($this->Form->isFieldError('password'))
			echo $this->Form->input('password', array('placeholder' => 'Mot de passe', 'div' => 'control-group error'));
		else
			echo $this->Form->input('password', array('placeholder' => 'Mot de passe'));

		if($this->Form->isFieldError('password2'))
			echo $this->Form->input('password2', array('type' => 'password', 'placeholder' => 'Confirmer le mot de passe', 'div' => 'control-group error'));
		else
			echo $this->Form->input('password2', array('type' => 'password', 'placeholder' => 'Confirmer le mot de passe'));
	?>

<?php echo $this->Form->end(array(
	'label' => 'Inscription',
	'div' => false,
	'class' => 'btn btn-primary'
)); ?>