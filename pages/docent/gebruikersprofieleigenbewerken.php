<div>
	<h1 id="titelgebruikersprofiel"><?php echo $lang["USER_PROFILE"];?></h1>
			<img class="profielfototje" src="images/unknown.png" alt="Profielfoto">
			</br>
			<button id="Buttonaanpassenprofiel"> <?php echo $lang["ADJUST_PROFILE_PICTURE"];?></button>
		<div class="Gebruikersprofielcontainer">
			<div id="Gebruikersprofielstudentinformatierechts"> 
				<form action=""></form>
				<p> <?php echo $lang["TEACHER_NUMBER"];?>: </p>
				<input type="text" name="Docentnummer"/>
				<p> <?php echo $lang["FIRST_NAME"];?> : </p>
				<input type="text" name="Voornaam"/>
				<p> <?php echo $lang["LAST_NAME"];?> : </p>
				<input type="text" name="Achternaam"/>
			</div>
			<div id="Gebruikersprofielstudentinformatielinks"> 
				<p> <?php echo $lang["E-MAIL"];?>: </p>
				<input type="text" name="E-mail"/>
				<p> <?php echo $lang["YEAR"];?>: </p>
				<input type="text" name="Jaar"/>
				<p> <?php echo $lang["PASSWORD"];?>: </p>
				<input type="text" name="Wachtwoord"/>
		</div>
	</div>
	<button id="Buttonopslaanprofiel">Opslaan</button>
</div>

<?php
	var_dump($_POST);
	if (ISSET($_POST['submitgegevens'])) {
		$Docentnummer = $_POST['Docentnummer'];
		$Voornaam = $_POST['Voornaam'];
		$Achternaam = $_POST['Achternaam'];
		$mail = $_POST['E-mail'];
		$Wachtwoord = $_POST['Wachtwoord'];

	if(!empty($Studentnummer) && !empty($Voornaam) && !empty($Achternaam) && !empty($Klas) && !empty($Studie) && !empty($mail) && !empty($Qachtwoord)){
        die("Vul alle velden in s.v.p.");
    }
?>