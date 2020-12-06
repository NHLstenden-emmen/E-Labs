<form action="createNewLabjournaal.php" method="post">
	<label for="title">Titel:</label> </br>
		<input type="text" name="title"> </br>
	<label for="theory">Theorie:</label> </br>
		<textarea name="theory"></textarea> </br>
	<label for="safety">Veiligheid:</label> </br>
		<textarea class="groteretextarealabjournaal" name="safety"></textarea> </br>
	<label for="logboek">Logboek:</label> </br>
		<textarea class="groteretextarealabjournaal" name="logboek"></textarea> </br>
	<label for="method_materials">Methode Materialen:</label> </br>
		<textarea class="groteretextarealabjournaal" name="method_materials"></textarea> </br>
	<label for="1">Year 1</label>
		<input type="radio" name="year" value="1" checked>
	<label for="1">Year 2</label>
		<input type="radio" name="year" value="2">
	<label for="1">Year 3</label>
		<input type="radio" name="year" value="3"> </br>
	<label for="fileupload">Upload file:</label> </br>
		<input type="file" name="fileupload"> </br>
	<label for="Goal">Doel:</label> </br>
		<textarea class="groteretextarealabjournaal" name="Goal"></textarea> </br>
	<label for="Hypothesis">Hypothese:</label> </br>
		<textarea class="groteretextarealabjournaal" name="Hypothesis"></textarea> </br>
	<input type="submit" name="opslaan" value="opslaan">	<input type="submit" name="inleveren" value="inleveren"> </br>
	<input type="reset" name="reset" value="Reset"> </br>
</form>

<?php
if(isset($_POST['inleveren'])){
	$title = $_POST['title'];
	$date =  date('Y-m-d H:i:s');
	$theory = $_POST['theory'];
	$safety = $_POST['safety'];
	$creater_id = $_SESSION['user_id'];
	$logboek = $_POST['logboek'];
	$method_materials = $_POST['method_materials'];
	$submitted = '1';
	$grade = '';
	$year = $_POST['year'];
	$Attachment = '';
	$Goal = $_POST['Goal'];
	$Hypothesis = 'Hypothesis';
	$message = $db->LabjournaalToevoegen($title, $date, $theory, $safety, $creater_id, $logboek, $method_materials, $submitted, $grade, $year, $Attachment, $Goal, $Hypothesis);
	echo $message;
}
if(isset($_POST['opslaan'])){
	$title = $_POST['title'];
	$date =  date('Y-m-d H:i:s');
	$theory = $_POST['theory'];
	$safety = $_POST['safety'];
	$creater_id = $_SESSION['user_id'];
	$logboek = $_POST['logboek'];
	$method_materials = $_POST['method_materials'];
	$submitted = '0';
	$grade = '';
	$year = $_POST['year'];
	$Attachment = '';
	$Goal = $_POST['Goal'];
	$Hypothesis = 'Hypothesis';
	$message = $db->LabjournaalToevoegen($title, $date, $theory, $safety, $creater_id, $logboek, $method_materials, $submitted, $grade, $year, $Attachment, $Goal, $Hypothesis);
	echo $message;
}
?>