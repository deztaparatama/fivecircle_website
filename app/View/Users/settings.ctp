<?php

	$this->assign('title', $title_for_layout);
	$status = array(
		1 => 'Membre',
		2 => 'Modérateur'
	);

?>

<div class="page-header">
	<h1>
		<?php echo $title_for_layout; ?>
	</h1>
</div>

<?php

	echo $this->Form->create('User', array(
		'class' => 'form-horizontal',
		'inputDefaults' => array(
			'div' => 'control-group',
			'between' => '<div class="controls">',
			'after' => '</div>'
		)
	));

	echo $this->Form->input('pseudo', array(
		'label' => array(
			'text' => 'Pseudo',
			'class' => 'control-label'
		),
		'disabled' => true
	));
	echo $this->Form->input('mail', array(
		'label' => array(
			'text' => 'Adresse email',
			'class' => 'control-label'
		)
	));
	if($this->Session->read('Auth.User.status') >= 2)
	{
		echo $this->Form->input('status', array(
			'options' => $status,
			'label' => array(
				'text' => 'Statut',
				'class' => 'control-label'
			)
		));
	}
	else
	{
		echo $this->Form->input('status', array(
			'label' => array(
				'text' => 'Statut',
				'class' => 'control-label'
			),
			'type' => 'text',
			'disabled' => true,
			'value' => $status[$this->data['User']['status']]
		));
	}

?>

<fieldset>
	<legend>Modification du mot de passe</legend>
<?php
	echo $this->Form->input('oldPassword', array(
		'label' => array(
			'text' => 'Ancien mot de passe',
			'class' => 'control-label'
		),
		'type' => 'password'
	));
	echo $this->Form->input('password', array(
		'label' => array(
			'text' => 'Nouveau mot de passe',
			'class' => 'control-label'
		),
		'type' => 'password',
		'value' => false
	));
	echo $this->Form->input('password2', array(
		'label' => array(
			'text' => 'Retapez le mot de passe',
			'class' => 'control-label'
		),
		'type' => 'password'
	));
?>
</fieldset>

<?php

	echo $this->Form->end(array(
		'label' => 'Enregistrer les modifications',
		'div' => 'form-actions',
		'class' => 'btn btn-primary'
	));

?>