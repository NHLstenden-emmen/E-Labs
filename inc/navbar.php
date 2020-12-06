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
		<?php if ($_SESSION['role'] == 'Docent') { ?>
			<li class="nav-item">
				<a class="nav-link" href="year1">Jaar 1</a>
			</li>
		<?php } else{ ?>
			<li class="nav-item">
				<a class="nav-link" href="labjournaal">Labjournaal</a>
			</li>
		<?php }?>
		<?php  if ($_SESSION['role'] == 'Docent') { ?>
			<li class="nav-item">
				<a class="nav-link" href="year2">Jaar 2</a>
			</li>
		<?php } else {?>
			<li class="nav-item">
				<a class="nav-link" href="#">Voorbereidingen</a>
			</li>
		<?php } ?>
		<?php  if ($_SESSION['role'] == 'Docent') { ?>
			<li class="nav-item">
				<a class="nav-link" href="year3">Jaar 3</a>
			</li>
		<?php } else {?>
			
		<?php } ?>
		</ul>
		<ul class="navbar-nav ml-auto">
			<li class="nav-item">
				<i class="fas fa-search fa-2x"></i>
			</li>
			<div class="btn-group topnavbar">
				<button type="button" class="btn"><?php echo $_SESSION['name'];?></button>
				<button type="button" class="btn dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<span class="sr-only">Toggle Dropdown</span>
				</button>
				<div class="dropdown-menu">
					<?php  if ($_SESSION['role'] == 'Docent') { ?>
						<a class="dropdown-item" href="editprof">editprof</a>
						<a class="dropdown-item" href="gebruikertoevoegen">gebruikertoevoegen</a>
					<?php } else {?>
						<a class="dropdown-item" href="editprofpic">editprofpic</a>
					<?php } ?>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item">
					<form method="post"> 
						<input type="submit" name="logout" class="dropdown-item" value="logout" /> 
					</form>
					<?php if(array_key_exists('logout', $_POST)) { 
						session_destroy(); 
						header("Location: login");
					} 
					?>
					</a>
				</div>
			</div>
		</ul>
		<div class="img-person">
			<img src="<?php 
			if (empty($_SESSION['pf_Pic'])) {
				echo "gebruikersBestanden/profilePictures/blank-profile-picture.png";
			} else {
				echo $_SESSION['pf_Pic'];
			}
			?>" class="rounded-circle">
		</div>
	</div>
</nav>
	<div class="slider">
		<img src="images/banner.jpg" class="img-fluid" alt="slider">
	</div>
