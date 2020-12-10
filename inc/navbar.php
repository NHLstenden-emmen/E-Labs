<?php 
	if(array_key_exists('logout', $_POST)) { 
		session_destroy(); 
		header("Location: login");
	} 
	if(isset($_GET['submit'])) {
		echo "geklikt";
	}
?>
<nav class="navbar navbar-expand-lg navbar-light bg-primary">
	<div class="img-logo">
		<img src="images/logo.png" alt="web logo">
	</div>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav mr-auto">
		<li class="nav-item">
			<a class="nav-link" href="home">E-labs</a>
		</li>
		<?php if ($_SESSION['role'] == 'Docent') { ?>
			<li class="nav-item">
				<a class="nav-link" href="grade?year=1"><?php echo $lang["YEAR_1"];?></a>
			</li>
		<?php } else{ ?>
			<li class="nav-item">
				<a class="nav-link" href="labjournaal"><?php echo $lang["LAB_JOURNAL"];?></a>
			</li>
		<?php }?>
		<?php  if ($_SESSION['role'] == 'Docent') { ?>
			<li class="nav-item">
				<a class="nav-link" href="grade?year=2"><?php echo $lang["YEAR_2"];?></a>
			</li>
		<?php } else {?>
			<li class="nav-item">
				<a class="nav-link" href="#"><?php echo $lang["PREPARATIONS"];?></a>
			</li>
		<?php } ?>
		<?php  if ($_SESSION['role'] == 'Docent') { ?>
			<li class="nav-item">
				<a class="nav-link" href="grade?year=3"><?php echo $lang["YEAR_3"];?></a>
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
				?>
						<form action="searchResults" method="get" id="searchForm">
							<input class="form-control" type="text" name="searchInput">
							<button type="submit" id="searchSubmitButton" class="btn btn-default" name="submit">
								<i class="fas fa-search fa-2x"></i>
							</button>
						</form>
				<?php
					}
				?>
			</li>
			<li class="btn-group topnavbar">
				<button type="button" class="btn"><?php echo $_SESSION['name'];?></button>
				<button type="button" class="btn dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<span class="sr-only">Toggle Dropdown</span>
				</button>
				<div class="dropdown-menu">
					<?php  if ($_SESSION['role'] == 'Docent') { ?>
						<a class="dropdown-item" href="gebruikersoverzicht"><?php echo $lang["USER_OVERVIEW"];?> </a>
						<a class="dropdown-item" href="gebruikertoevoegen"><?php echo $lang["ADD_USER"];?></a>
						<div class="dropdown-divider"></div>
					<?php } else {?>
					<?php } ?>
					<?php
						// check if there is a cookie for lang set
						if(!isset($_COOKIE['lang'])){
							echo "<form method='post' id='langSwitch' class='dropdown-item'>
									<button type='submit' value='en' class='languageSwitch' name='changelang'>
										EN
									</button>
								</form>
						";
						} // change the button to a dutch button cause the lang is set to english
						else if($_COOKIE['lang'] == 'en'){
							echo "<form method='post' id='langSwitch'>
									<button type='submit' value='nl' class='languageSwitch' name='changelang'>
									NL
									</button>
								</form>
						";
						} // change the button to a english button cause the lang is set to dutch
						else if($_COOKIE['lang'] == 'nl'){
							echo "<form method='post' id='langSwitch'>
									<button type='submit' value='en' class='languageSwitch' name='changelang'>
										EN
									</button>
								</form>
						";
						}
					?>
					<div class="dropdown-divider"></div>
					<div class="dropdown-item">
						<form method="post"> 
							<input type="submit" name="logout" class="dropdown-item" value="<?php echo $lang["LOGOUT"];?>" /> 
						</form>
					</div>
				</div>
			</li>
		</ul>
		<div class="img-person">
			<a href="gebruikersprofiel">
				<img src="<?php 
				if (empty($_SESSION['pf_Pic'])) {
					echo "gebruikersBestanden/profilePictures/blank-profile-picture.png";
				} else {
					echo $_SESSION['pf_Pic'];
				}
				?>" alt="profile foto in header" class="rounded-circle nav-profile-pic">
			</a>
		</div>
	</div>
</nav>
<div class="slider">
	<img src="images/banner.jpg" class="img-fluid" alt="slider">
</div>