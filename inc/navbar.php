<nav class="navbar navbar-expand-lg navbar-light bg-primary">
	<div class="img-logo">
		<img src="images/logo.png">
	</div>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto text-light">
      <li class="nav-item">
        <a class="nav-link text-light" href="#">E-labs</a>
      </li>
	  <?php  if (isset($_SESSION['username']) && $_SESSION['rol'] == 'docent') { ?>
		  <li class="nav-item">
			<a class="nav-link text-light" href="#">Jaar 1</a>
		  </li>
		  <div class="streepje"></div>
	  <?php } else{ ?>
		   <li class="nav-item">
			<a class="nav-link text-light" href="#">Labjournaal</a>
		  </li>
	  <?php }?>
	  <?php  if (isset($_SESSION['username']) && $_SESSION['rol'] == 'docent') { ?>
		  <li class="nav-item">
			<a class="nav-link text-light" href="#">Jaar 2</a>
		  </li>
	  <?php } else {?>
		  <li class="nav-item">
			<a class="nav-link text-light" href="#">Voorbereidingen</a>
		  </li>
	  <?php } ?>
	  <?php  if (isset($_SESSION['username']) && $_SESSION['rol'] == 'docent') { ?>
		  <li class="nav-item">
			<a class="nav-link text-light" href="#">Jaar 3</a>
		  </li>
	  <?php } else {?>
		<li class="nav-item">
			<a class="nav-link text-light" href="#">Protocool</a>
		</li>
	  <?php } ?>
    </ul>
	<ul class="navbar-nav ml-auto text-light">
		<li class="nav-item">
			<i class="fas fa-search fa-2x"></i>
		</li>
		<li class="nav-item">
			<a class="nav-link text-light" href="#">Gebruikers Naam</a>
		</li>
		<li class="nav-item">
		</li>
	</ul>
		<div class="img-logo">
			<img src="images/person.jpg" class="rounded-circle">
		</div>
   </div>
</nav>
    <div class="slider">
        <img src="images/banner.jpg" class="img-fluid" alt="slider">
    </div>
