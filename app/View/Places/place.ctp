<?php

	$this->assign('title', $title_for_layout);

?>

<div class="page-header">
	<h1><?php echo $title_for_layout; ?></h1>
</div>

<div class="row-fluid">
	<div class="span5 well well-small centre">
		<?php echo $this->Html->image('places/' . $place['Place']['photo_name']); ?>
	</div>
	<div class="span7 well well-small centre">
		<img src="http://maps.googleapis.com/maps/api/staticmap?center=<?php echo $place['Place']['latitude']; ?>,<?php echo $place['Place']['longitude']; ?>&zoom=15&size=640x300&sensor=false&markers=color:red%7C<?php echo $place['Place']['latitude']; ?>,<?php echo $place['Place']['longitude']; ?>">
	</div>
</div>

<div class="page-header">
	<h1>Activités de la place</h1>
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
					<?php echo $this->Html->image('users/' . $v['User']['photo_name']); ?>
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