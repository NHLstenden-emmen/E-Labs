<?php
if(isset($_GET['labjournaal'])) {
	$labjournaalid = $_GET['labjournaal'];
} else {
	$labjournaalid = 'not found';
}

if(isset($_POST['submit'])){
	$grade = $_POST['grade'];
	$db->updateGradeVieuw($labjournaalid, $grade);
}

$labjournal = $db->DocentLabjournaalView($labjournaalid);
?>


<?php
	while ($result = $labjournal->fetch_array(MYSQLI_ASSOC)){
		echo "<h1 class='labjournaaltitle'>" . $result['title'] . "</h1>";
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
			<input type='submit' value='submit'>
			<input type='hidden' value='submit' name='submit' id='submit'>
		</form>
		</div>";
	}

?>
</div>