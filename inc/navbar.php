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
				<a class="nav-link" href="#">Jaar 1</a>
			</li>
		<?php } else{ ?>
			<li class="nav-item">
				<a class="nav-link" href="labjournaal">Labjournaal</a>
			</li>
		<?php }?>
		<?php  if ($_SESSION['role'] == 'Docent') { ?>
			<li class="nav-item">
				<a class="nav-link" href="#">Jaar 2</a>
			</li>
		<?php } else {?>
			<li class="nav-item">
				<a class="nav-link" href="#">Voorbereidingen</a>
			</li>
		<?php } ?>
		<?php  if ($_SESSION['role'] == 'Docent') { ?>
			<li class="nav-item">
				<a class="nav-link" href="#">Jaar 3</a>
			</li>
		<?php } else {?>
			
		<?php } ?>
		</ul>
		<ul class="navbar-nav ml-auto">
			<li class="nav-item">
				<a href="?search" id="searchIcon" <?php if(isset($_GET['search'])){ echo "style='display:none'"; } ?> class="search-form-tigger">
					<i class="fas fa-search fa-2x"></i>
				</a>
				<?php 
					if(isset($_GET['search'])) {
						echo "<form action='#' method='get' id='searchForm'>";
						echo "<input class='form-control' type='text'>";
						echo "<button type='submit' class='btn btn-default' name='submit'>";
						echo "<i class='fas fa-search fa-2x'></i>";
						echo "</button>";
						echo "</form>";
					}
				?>
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

<?php 
	if(isset($_GET['submit'])) {
		echo "geklikt";
	}

?>