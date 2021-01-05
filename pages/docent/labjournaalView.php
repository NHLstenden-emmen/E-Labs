<?php
if(isset($_GET['labjournaal'])) {
	$labjournaalid = $_GET['labjournaal'];
} else {
	$labjournaalid = 'not found';
}

if(isset($_POST['changeGrade'])){
	if ($_POST['grade'] <= 10 && $_POST['grade'] >= 0) {
		$grade = $_POST['grade'];
		$db->updateGradeVieuw($labjournaalid, $grade);
		echo "cijer bijgewerkt";
	} else {
		echo "dit is geen correct cijfer";
	}
}
if(isset($_POST['archive'])){
	$db->archiveLabjournaal($_GET['labjournaal'], 2);
}
if(isset($_POST['unArchive'])){
	$db->archiveLabjournaal($_GET['labjournaal'], 1);
}

$labjournal = $db->DocentLabjournaalView($labjournaalid);
?>


<?php
	while ($result = $labjournal->fetch_array(MYSQLI_ASSOC)){
		echo "<h1 class='labjournaaltitle'>" . $result['title'] . "</h1>";
		if ($result['submitted'] == 2) {
			echo "<form method='POST'>
					<input type='submit' value='Un archive' name='unArchive'>
				</form>";
		} else {
			echo "<form method='POST'>
					<input type='submit' value='Archive' name='archive'>
				</form>";
		}
		
		?>
		<div class="labjournaalcontainer">
		<?php
		echo "<div class='groteretextarealabjournaal'><h4>$lang[NAME]: </h4>" . "<p>" . $result['name'] . "</p></div>";
		echo "<div class='grotetextarealabjournaal'><h4>$lang[DATE]: </h4>" . "<p>" . $result['date'] . "</p></div>";
		echo "<div class='grotetextarealabjournaal'><h4>$lang[GOAL]: </h4>" . "<p>" . $result['Goal'] . "</p></div>";
		echo "<div class='grotetextarealabjournaal'><h4>$lang[HYPOTHESIS]: </h4>" . "<p>" . $result['Hypothesis'] . "</p></div>";
		echo "<div class='grotetextarealabjournaal'><h4>$lang[MATERIALS]: </h4>" . "<p>" . $result['method_materials'] . "</p></div>";
		echo "<div class='grotetextarealabjournaal'><h4>$lang[THEORY]: </h4>" . "<p>" . $result['theory'] . "</p></div>";
		echo "<div class='grotetextarealabjournaal'><h4>$lang[SAFETY]: </h4>" . "<p>" . $result['safety'] . "</p></div>";
		echo "<div class='grotetextarealabjournaal'><h4>$lang[RESULT]: </h4>" . "<p>" . $result['logboek'] . "</p></div>";
		echo "<div class='grotetextarealabjournaal'><h4>$lang[DOCUMENT]: </h4>" . "<p>" . $result['Attachment'] . "</p></div>";
		echo "<div class='grotetextarealabjournaal'><h4>$lang[GRADE]: </h4> 
		<form method='POST'>
			<input type='text' name='grade' value=" .$result['grade'] . ">
			<input type='submit' name='changeGrade'>
		</form>
		</div>";
	}

?>
</div>