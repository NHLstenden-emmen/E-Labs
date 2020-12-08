<?php
$name = $_SESSION['name'];
$email = $_SESSION['email'];
$stud_id = $_SESSION['user_id'];
$lang = $_COOKIE['lang'];
$pf_pic = $_SESSION['pf_Pic'];
?>

<div>
	<h1 id="titelgebruikersprofiel">Gebruikersprofiel</h1>
			<img class="profielfototje" src="<?=$pf_pic?>" alt="Profielfoto">
			</br>
			<a href="editprofpic"><button id="Buttonaanpassenprofiel">Profielfoto aanpassen</button></a>
		<div class="Gebruikersprofielcontainer">
			<div id="Gebruikersprofielstudentinformatierechts"> 
				<p> Studentnummer: </p>
				<p id="profielinformatiekleurgrijs"> <?=$stud_id?></p>
				<p> Naam: </p>
				<p id="profielinformatiekleurgrijs"> <?=$name?></p>
			</div>
			<div id="Gebruikersprofielstudentinformatielinks"> 
				<p> E-mail: </p>
				<p id="profielinformatiekleurgrijs">  <?=$email?> </p>
				<p> language: </p>
				<p id="profielinformatiekleurgrijs">  <?=$lang?> </p>
			</div>
		</div>
	</div>
</div>