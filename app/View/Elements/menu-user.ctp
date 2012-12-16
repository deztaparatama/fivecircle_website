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
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $this->Session->read('Auth.User.mail'); ?> <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li>
								<?php echo $this->Html->link('<i class="icon-user"></i>Mon profil', array('controller' => 'users', 'action' => 'profile'), array('escape' => false)); ?>
							</li>
							<li>
								<?php echo $this->Html->link('<i class="icon-wrench"></i>Réglages', array('controller' => 'users', 'action' => 'settings'), array('escape' => false)); ?>
							</li>
							<li class="divider"></li>
							<li>
								<?php echo $this->Html->link('<i class="icon-off"></i>Se déconnecter', array('controller' => 'users', 'action' => 'logout'), array('escape' => false)); ?>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>