<?php

	$this->assign('title', 'Liste de vos amis');

?>

<div class="hero-unit">
	<h1>Liste de vos amis</h1>
	<p>
		Trouvez ici tous vos amis inscrits sur ce site
	</p>
</div>

<table class="table table-striped table-bordered table-hover">
	<thead>
		<tr>
			<th>Pseudo</th>
			<th>Prénom</th>
			<th>Nom</th>
			<th>Date d'inscription</th>
			<th>Nombre de lieux visités</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($users as $v): ?>
			<tr>
				<td><?php echo $this->Html->link($v['User']['pseudo'], array('controller' => 'users', 'action' => 'profile', $v['User']['id'])); ?></td>
				<td><?php echo $v['User']['surname']; ?></td>
				<td><?php echo $v['User']['name']; ?></td>
				<td><?php echo $v['User']['created']; ?></td>
				<td><?php echo $v['User']['nbVisited']; ?></td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>