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

			<hr>
			<footer>
				Site web créé par Mickaël Bourgier
				<div class="pull-right">
					Application mobile par Timothé Bournay, Vincent Dimper, Benoit Gros et Alexandre Pinto
				</div>
			</footer>

			<?php echo $this->element('sql_dump'); ?>

		</div>

		<?php

			echo $this->Html->script('jquery');
			echo $this->Html->script('bootstrap-transition');
			echo $this->Html->script('bootstrap-alert');
			echo $this->Html->script('bootstrap-modal');
			echo $this->Html->script('bootstrap-dropdown');
			echo $this->Html->script('bootstrap-scrollspy');
			echo $this->Html->script('bootstrap-tab');
			echo $this->Html->script('bootstrap-tooltip');
			echo $this->Html->script('bootstrap-popover');
			echo $this->Html->script('bootstrap-button');
			echo $this->Html->script('bootstrap-collapse');
			echo $this->Html->script('bootstrap-carousel');
			echo $this->Html->script('bootstrap-typeahead');
			
		?>

	</body>

</html>