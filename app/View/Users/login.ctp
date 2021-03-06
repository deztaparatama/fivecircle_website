<?php

	$this->start('style'); ?>
		body
		{
			background-color: #f5f5f5;
		}
	<?php $this->end();

	$this->assign('title', 'Connexion');

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
	
	<h2 class="form-signin-heading">Connectez-vous !</h2>

	<?php echo $this->Form->input('pseudo', array('placeholder' => 'Pseudo')); ?>
	<?php echo $this->Form->input('password', array('placeholder' => 'Mot de passe')); ?>

<?php echo $this->Form->end(array(
	'label' => 'Connexion',
	'div' => false,
	'class' => 'btn btn-primary'
)); ?>

<div class="centre">
	Pas de compte ? <?php echo $this->Html->link('Inscrivez-vous', array('controller' => 'users', 'action' => 'signup')); ?> !
</div>
