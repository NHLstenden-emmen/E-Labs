<?php
if(isset($_GET['labjournaal'])) {
	$labjournaalid = $_GET['labjournaal'];
} else {
	$labjournaalid = 'not found';
}
$labjournal = $db->DocentLabjournaalView($labjournaalid);

while ($result = $labjournal->fetch_array(MYSQLI_ASSOC)){
	echo "<h1>" . $result['title'] . "</h1>";
	echo "<p>$lang[NAME]: " . $result['name'] . "</p>";
	echo "<p>$lang[DATE]: " . $result['date'] . "</p>";
	echo "<p>$lang[RESULT]: " . $result['theory'] . "</p>";
	echo "<p>$lang[SAFETY]: " . $result['safety'] . "</p>";
	echo "<p>$lang[RESULT]: " . $result['logboek'] . "</p>";
	echo "<p>$lang[MATERIAL]: " . $result['method_materials'] . "</p>";
	if(empty($result['grade'])) {
		echo "<p>Cijfer: Nog niet beoordeeld</p>";
	} else {
		echo "<p>$lang[GRADE]: " . $result['grade'] . "</p>";
	}
	echo "<p>$lang[GOAL]: " . $result['Goal'] . "</p>";
	echo "<p>$lang[YEAR]: " . $result['year'] . "</p>";
	echo "<p>Document: " . $result['Attachment'] . "</p>";
	echo "<p>$lang[HYPOTHESIS]: " . $result['Hypothesis'] . "</p>";
}

?>