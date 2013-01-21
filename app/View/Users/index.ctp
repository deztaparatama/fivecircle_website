<?php

	$this->assign('title', 'Accueil');

?>

<div class="hero-unit">
	<h1>Activités de vos amis <small>Modifier ça !</small></h1>
	<p>
		Trouvez ici tous les lieux qu'ont fréquenté vos amis !
	</p>
</div>

<?php foreach($timeline as $v): ?>
	
	<div class="well">
		<div class="pull-left placeThumbnail">
			<?php echo $this->Html->image('places/' . $v['Place']['photo_name']); ?>
			<br><em class="centre"><?php echo $v['Place']['name']; ?></em>
		</div>
		<?php if(!empty($v['User']['surname']) OR !empty($v['User']['name'])): ?>
			<strong><?php echo $v['User']['surname'] . ' ' . $v['User']['name']; ?></strong>
		<?php else: ?>
			<strong><?php echo $v['User']['pseudo']; ?></strong>
		<?php endif; ?>
		<?php if(!empty($v['PlaceComment'])): ?>
			<blockquote class="pull-right"><p><?php echo $v['PlaceComment']['content']; ?></p></blockquote>
		<?php endif; ?>
		<?php if(!empty($v['Mark']['mark'])): ?>
			<br>Sa note : <span class="placeMark"><?php echo $v['Mark']['mark']; ?></span>
		<?php endif ?>
		<div class="clearfix"></div>
	</div>

<?php endforeach; ?>
