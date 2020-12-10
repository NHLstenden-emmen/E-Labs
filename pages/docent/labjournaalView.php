<?php
if(isset($_GET['labjournaal'])) {
	$labjournaalid = $_GET['labjournaal'];
} else {
	$labjournaalid = 'not found';
}

$newsql = new Database();
$labjournal2 = $newsql->DocentLabjournaalView($labjournaalid);

while ($result = $labjournal2->fetch_array(MYSQLI_ASSOC)){
	echo "<h1>" . $result['title'] . "</h1>";
	echo "<p>Naam: " . $result['name'] . "</p>";
	echo "<p>Datum: " . $result['date'] . "</p>";
	echo "<p>Resultaat: " . $result['theory'] . "</p>";
	echo "<p>Veiligheid: " . $result['safety'] . "</p>";
	echo "<p>Resultaat: " . $result['logboek'] . "</p>";
	echo "<p>Materiaal: " . $result['method_materials'] . "</p>";
	if(empty($result['grade'])) {
		echo "<p>Cijfer: Nog niet beoordeeld</p>";
	} else {
		echo "<p>Cijfer: " . $result['grade'] . "</p>";
	}
	if(empty($result['goal'])) {
		echo "<p>Goal: Geen goal</p>";
	} else {
		echo "<p>Goal: " . $result['goal'] . "</p>";
	}
	echo "<p>Jaar: " . $result['year'] . "</p>";
	echo "<p>Document: " . $result['Attachment'] . "</p>";
	echo "<p>Hypothese: " . $result['Hypothesis'] . "</p>";
}

?>