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
				if($user['User']['id'] != $this->Session->read('Auth.User.id'))
				{
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
			<li><strong>Nombre de lieux visités</strong> : <?php echo $user['User']['nbVisited']; ?></li>
		</ul>
	</div>
</div>

<div class="page-header">
	<h1>
		<?php
		if($user['User']['id'] == $this->Session->read('Auth.User.id'))
			echo 'Vos activités';
		else
			echo 'Ses activités';
		?>
	</h1>
</div>

<div class="timeline">
	<?php foreach ($user['Timeline'] as $v) : ?>

		<div class="row-fluid">
			<div class="span6 offset3 well">
				<div class="pull-left">
					<?php echo $this->Html->image('places/' . $v['Place']['photo_name']); ?>
				</div>
				<p>
					<strong><?php echo $this->Html->link($v['Place']['name'], array('controller' => 'places', 'action' => 'place', $v['Place']['id']), array('class' => 'blackLink')); ?></strong><br>
					Le <?php echo $this->Date->show($v['Visited']['created'], true, false, true); ?>
					<?php if (isset($v['Mark'])): ?>
						<br>Sa note : <span class="rating<?php echo $v['Mark']['mark'] ?>"></span>
					<?php endif; ?>
					<?php if (isset($v['PlaceComment'])): ?>
						<blockquote class="pull-right"><?php echo $v['PlaceComment']['content']; ?></blockquote>
					<?php endif; ?>
				</p>
				<div class="clearfix"></div>
			</div>
		</div>

	<?php endforeach ?>
</div>