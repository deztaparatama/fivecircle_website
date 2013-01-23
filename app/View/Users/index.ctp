<?php

	$this->assign('title', 'Accueil');

?>

<div class="hero-unit">
	<h1>Activités de vos amis</h1>
	<p>
		Trouvez ici tous les lieux qu'ont fréquenté vos amis !
	</p>
</div>

<div class="timeline">
	<?php
	foreach ($timeline as $v) :
		$userName = (!empty($v['User']['surname'])) ? $v['User']['surname'] : '';
		$userName .= (!empty($v['User']['name'])) ? ' ' . $v['User']['name'] : '';
		$userName = (empty($userName)) ? $v['User']['pseudo'] : $userName;
	?>

		<div class="row-fluid">
			<div class="span6 offset3 well">
				<div class="pull-left">
					<?php echo $this->Html->image('places/' . $v['Place']['photo_name']); ?>
				</div>
				<p>
					<strong><?php echo $v['Place']['name']; ?></strong><br>
					A été visité par <?php echo $this->Html->link($userName, array(
						'controller' => 'users',
						'action' => 'profile',
						$v['User']['id']
					)); ?>,<br>
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