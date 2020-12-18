<?php
if(isset($_GET['labjournaal'])) {
	$labjournaalid = $_GET['labjournaal'];
} else {
	$labjournaalid = 'not found';
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
		echo "<div class='grotetextarealabjournaal'><h4>$lang[RESULT]: </h4>" . "<p>" . $result['theory'] . "</p></div>";
		echo "<div class='grotetextarealabjournaal'><h4>$lang[SAFETY]: </h4>" . "<p>" . $result['safety'] . "</p></div>";
		echo "<div class='grotetextarealabjournaal'><h4>$lang[RESULT]: </h4>" . "<p>" . $result['logboek'] . "</p></div>";
		echo "<div class='grotetextarealabjournaal'><h4>$lang[MATERIAL]: </h4>" . "<p>" . $result['method_materials'] . "</p></div>";
		if(empty($result['grade'])) {
			echo "<div class='grotetextarealabjournaal'><h4>$lang[GRADE]: </h4>" . "<p> Nog niet beoordeeld </p></div>";
		} else {
			echo "<div class='grotetextarealabjournaal'><h4>$lang[GRADE]: </h4>" . "<p>" . $result['grade'] . "</p></div>";
		}
		echo "<div class='grotetextarealabjournaal'><h4>$lang[GOAL]: </h4>" . "<p>" . $result['Goal'] . "</p></div>";
		echo "<div class='grotetextarealabjournaal'><h4>$lang[YEAR]: </h4>" . "<p>" . $result['year'] . "</p></div>";
		echo "<div class='grotetextarealabjournaal'><h4>$lang[DOCUMENT]: </h4>" . "<p>" . $result['Attachment'] . "</p></div>";
		echo "<div class='grotetextarealabjournaal'><h4>$lang[HYPOTHESIS]: </h4>" . "<p>" . $result['Hypothesis'] . "</p></div>";
	}

?>
</div>