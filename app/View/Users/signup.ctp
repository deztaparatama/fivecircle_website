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
		'div' => 'control-group',
		'class' => 'input-block-level',
		'error' => array(
			'attributes' => array(
				'wrap' => 'span',
				'class' => 'help-inline'
			)
		)
	)
)); ?>
	
	<h2 class="form-signin-heading">Inscrivez-vous !</h2>

	<?php

		echo $this->Form->input('pseudo', array('placeholder' => 'Pseudo'));
		echo $this->Form->input('mail', array('placeholder' => 'Adresse email'));
		echo $this->Form->input('password', array('placeholder' => 'Mot de passe'));
		echo $this->Form->input('password2', array('type' => 'password', 'placeholder' => 'Confirmer le mot de passe'));

	?>

<?php echo $this->Form->end(array(
	'label' => 'Inscription',
	'div' => false,
	'class' => 'btn btn-primary'
)); ?>
