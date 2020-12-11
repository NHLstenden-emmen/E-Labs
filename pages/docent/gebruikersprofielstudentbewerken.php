<?php
	$email = $_SESSION['email'];
	$userid = $_SESSION['user_id'];
	$volnaam = $_SESSION['name'];
	$pfpic = $_SESSION['pf_Pic'];
	$usernumber = $_SESSION['user_number'];
	$db->selectCurrentUsers($email, $userid, $volnaam, $pfpic, $usernumber);
?>

<div>
	<h1 id="titelgebruikersprofiel"><?php echo $lang["USER_PROFILE"];?></h1>
			<img class="profielfototje" src="images/unknown.png" alt="Profielfoto">
			</br>
		<form action="gebruikersprofiel.php" method="POST">
			<button id="Buttonaanpassenprofiel"> <?php echo $lang["ADJUST_PROFILE_PICTURE"];?></button>
		<div class="Gebruikersprofielcontainer">
			<div id="Gebruikersprofielstudentinformatierechts"> 
				
				<p> <?php echo $lang["STUDENT_NUMBER"];?>: </p>
				<input type="text" name="Studentnummer"/>
				<p> <?php echo $lang["NAME"];?> : </p>
				<input type="text" name="Naam"/>
				<p> <?php echo $lang["E-MAIL"];?>: </p>
				<input type="text" name="E-mail"/>
			</div>
			<div id="Gebruikersprofielstudentinformatielinks"> 
				
				<p> <?php echo $lang["PASSWORD"];?>: </p>
				<input type="text" name="Wachtwoord"/>
				<p> <?php echo $lang["PASSWORD"];?>: </p>
				<input type="text" name="Wachtwoordnogmaals"/>
		</div>
	</div>
		<input type="submit" name="submitgegevens" value="Opslaan" id="Buttonopslaanprofiel">
		<input type="reset" name="resetgegevens" value="Reset" id="Buttonopslaanprofiel">
</div>
</form>

<?php
	var_dump($_POST);
	if (ISSET($_POST['submitgegevens'])) {
		$Studentnummer = $_POST['Studentnummer'];
		$Naam = $_POST['Naam'];
		$Mail = $_POST['E-mail'];
		$Wachtwoord = $_POST['Wachtwoord'];
		$Wachtwoordnog = $_POST['Wachtwoordnogmaals'];
	}
	if(!empty($Studentnummer) && !empty($Naam) && !empty($Mail) && !empty($Wachtwoord) && !empty($Wachtwoordnog)){
		if ($Wachtwoord != $Wachtwoordnog) {
			die("Wachtwoorden komen niet overeen.");
		}
        die("Vul alle velden in s.v.p.");
    }
    $db->docentstudentprofielbewerken($Studentnummer, $Naam, $Mail, $Wachtwoord, $Wachtwoordnog);
?>