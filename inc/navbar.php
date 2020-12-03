<nav class="navbar navbar-expand-lg navbar-light bg-primary">
	<div class="img-logo">
		<img src="images/logo.png">
	</div>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controles="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav mr-auto">
		<li class="nav-item">
			<a class="nav-link" href="home">E-labs</a>
			
		</li>
		<?php if (isset($_SESSION['username']) && $_SESSION['role'] == 'Docent') { ?>
			<li class="nav-item">
				<a class="nav-link" href="#">Jaar 1</a>
			</li>
		<?php } else{ ?>
			<li class="nav-item">
				<a class="nav-link" href="labjournaal">Labjournaal</a>
			</li>
		<?php }?>
		<?php  if (isset($_SESSION['username']) && $_SESSION['role'] == 'Docent') { ?>
			<li class="nav-item">
				<a class="nav-link" href="#">Jaar 2</a>
			</li>
		<?php } else {?>
			<li class="nav-item">
				<a class="nav-link" href="#">Voorbereidingen</a>
			</li>
		<?php } ?>
		<?php  if (isset($_SESSION['username']) && $_SESSION['role'] == 'Docent') { ?>
			<li class="nav-item">
				<a class="nav-link" href="#">Jaar 3</a>
			</li>
		<?php } else {?>
			
		<?php } ?>
		</ul>
		<ul class="navbar-nav ml-auto">
			<li class="nav-item">
				<i class="fas fa-search fa-2x"></i>
			</li>
			<li class="nav-item1">
				<a class="nav-link" href="#">Gebruikers Naam</a>
			</li>
		</ul>
		<div class="img-person">
			<img src="images/person.jpg" class="rounded-circle">
		</div>
	</div>
</nav>
	<div class="slider">
		<img src="images/banner.jpg" class="img-fluid" alt="slider">
	</div>
