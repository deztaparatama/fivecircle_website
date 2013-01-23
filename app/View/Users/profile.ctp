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
				if($user['User']['id'] == $this->Session->read('Auth.User.id'))
				{
					echo $this->Html->link(
						'<i class="icon-wrench"></i> Réglages',
						array('controller' => 'users', 'action' => 'settings'),
						array('escape' => false, 'class' => 'btn')
					);
				}
				else
				{
					echo $this->Html->link(
						'<i class="icon-envelope"></i> Envoyer un mail',
						'mailto:' . $user['User']['mail'],
						array('escape' => false, 'class' => 'btn')
					);
				}
				echo '&nbsp;';
				if($isFriend)
				{
					echo $this->Html->link(
						'<i class="icon-remove icon-white"></i> Supprimer des amis',
						array('controller' => 'users', 'action' => 'removeFriend', $user['User']['id']),
						array('escape' => false, 'class' => 'btn btn-danger')
					);
				}
				else
				{
					echo $this->Html->link(
						'<i class="icon-plus icon-white"></i> Ajouter en amis',
						array('controller' => 'users', 'action' => 'addFriend', $user['User']['id']),
						array('escape' => false, 'class' => 'btn btn-success')
					);
				}
			?>
		</div>
	</h1>
</div>

<div class="row">
	<div class="span2">
		<?php echo $this->Html->image('users/' . $user['User']['photo_name'], array('class' => 'well well-small')); ?>
	</div>
	<div class="span5">
		<h4><i class="icon-user h4"></i> Informations personnelles</h4>
		<ul>
			<li><strong>Nom</strong> : <?php echo $user['User']['name']; ?></li>
			<li><strong>Prénom</strong> : <?php echo $user['User']['surname']; ?></li>
			<li><strong>Date de naissance</strong> : Le <?php echo $this->Date->show($user['User']['date_birth']); ?></li>
		</ul>
	</div>
	<div class="span5">
		<h4><i class="icon-file h4"></i> Informations utilisateur</h4>
		<ul>
			<li><strong>Statut</strong> : <?php echo $status[$user['User']['status']]; ?></li>
			<li><strong>Date d'inscription</strong> : Le <?php echo $this->Date->show($user['User']['created'], true, true, true); ?></li>
		</ul>
	</div>
</div>
