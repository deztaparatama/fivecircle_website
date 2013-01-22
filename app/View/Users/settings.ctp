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
		<div class="pull-right">
			<?php
				if($this->request->data['User']['id'] == $this->Session->read('Auth.User.id'))
				{
					echo $this->Html->link(
						'<i class="icon-user"></i> Profil',
						array('controller' => 'users', 'action' => 'profile'),
						array('escape' => false, 'class' => 'btn')
					);
				}
				else
				{
					echo $this->Html->link(
						'<i class="icon-user"></i> Profil',
						array('controller' => 'users', 'action' => 'profile', $this->request->data['User']['id']),
						array('escape' => false, 'class' => 'btn')
					);
				}
			?>
		</div>
	</h1>
</div>

<?php

	echo $this->Form->create('User', array(
		'type' => 'file',
		'class' => 'form-horizontal',
		'inputDefaults' => array(
			'format' => array('before', 'label', 'between', 'input', 'error', 'after'),
			'div' => 'control-group',
			'between' => '<div class="controls">',
			'after' => '</div>',
			'error' => array(
				'attributes' => array(
					'wrap' => 'span',
					'class' => 'help-inline'
				)
			)
		)
	));

?>

<div class="tabbable">
	<ul class="nav nav-tabs">
		<li class="active">
			<?php echo $this->Html->link('Informations utilisateur', '#tab1', array('data-toggle' => 'tab')); ?>
		</li>
		<li>
			<?php echo $this->Html->link('Informations personnelles', '#tab2', array('data-toggle' => 'tab')); ?>
		</li>
		<li>
			<?php echo $this->Html->link('Photo de profil', '#tab3', array('data-toggle' => 'tab')); ?>
		</li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="tab1">
			<?php
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
		</div>
		<div class="tab-pane" id="tab2">
			<?php
				echo $this->Form->input('name', array(
					'label' => array(
						'text' => 'Nom',
						'class' => 'control-label'
					)
				));
				echo $this->Form->input('surname', array(
					'label' => array(
						'text' => 'Prénom',
						'class' => 'control-label'
					)
				));
				echo $this->Form->input('date_birth', array(
					'label' => array(
						'text' => 'Date de naissance',
						'class' => 'control-label'
					),
					'type' => 'text',
					'value' => $this->Date->show($this->request->data['User']['date_birth']),
					'id' => 'datepicker'
				));
			?>
		</div>
		<div class="tab-pane" id="tab3">
			<div class="control-group">
				<label class="control-label">Votre photo actuelle :</label>
				<div class="controls">
					<?php echo $this->Html->image('users/' . $this->data['User']['photo_name'], array('class' => 'well well-small')); ?>
				</div>
			</div>
			<?php
				echo $this->Form->input('photo', array(
					'label' => array(
						'text' => 'Changer votre photo :',
						'class' => 'control-label'
					),
					'type' => 'file',
					'value' => ''
				));
			?>
		</div>
	</div>
</div>

<?php

	echo $this->Form->end(array(
		'label' => 'Enregistrer les modifications',
		'div' => 'form-actions',
		'class' => 'btn btn-primary'
	));

?>