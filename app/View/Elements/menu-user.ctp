<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container-fluid">
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			<?php echo $this->Html->link('five<strong>circle</strong>', '/', array('class' => 'brand', 'escape' => false)); ?>
			<div class="nav-collapse">
				<ul class="nav pull-right">
					<li><?php echo $this->Html->link('Se déconnecter', array('controller' => 'users', 'action' => 'logout')) ?></li>
				</ul>
			</div>
		</div>
	</div>
</div>