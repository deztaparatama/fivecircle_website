<?php

	$this->assign('title', 'Liste des membres');

?>

<div class="hero-unit">
	<h1>Liste des membres</h1>
	<p>
		Trouvez ici tous les membres inscrits sur ce site
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
				<td>Le <?php echo $this->Date->show($v['User']['created'], true, false, true); ?></td>
				<td><?php echo $v['User']['nbVisited']; ?></td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>