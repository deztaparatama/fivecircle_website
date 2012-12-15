<!DOCTYPE html>
<html lang="fr">

	<head>

		<?php echo $this->Html->charset(); ?>
		<title>fivecircle - <?php echo $this->fetch('title'); ?></title>
		<?php echo $this->Html->css('bootstrap'); ?>
		<?php echo $this->Html->css('responsive'); ?>
		<style type="text/css">
			<?php echo $this->fetch('style'); ?>
		</style>

	</head>

	<body>

		<?php echo $this->Element('menu-user'); ?>

		<div class="container-fluid">

			<?php echo $this->Session->flash(); ?>
			<?php echo $this->Session->flash('auth', array('element' => 'flash', 'params' => array('type' => 'error'))); ?>
			
			<?php echo $this->fetch('content'); ?>

			<?php echo $this->element('sql_dump'); ?>

		</div>

		<?php echo $this->fetch('js'); ?>

	</body>

</html>