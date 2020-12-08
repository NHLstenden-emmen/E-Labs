<div>
<form action="createNewLabjournaal.php" method="post" class="newlabjournaalcontainer">
		<label for="title">Titel:</label> </br>
			<input type="text" name="title" class="nieuwetitellabjournaal"> </br>
	<div>
		 </br> <label for="Goal">Doel:</label> </br>
			<textarea class="groteretextarealabjournaal" name="Goal"></textarea> </br> </br>
	</div>
	<div>
		</br> <label for="Hypothesis">Hypothese:</label> </br>
			<textarea class="groteretextarealabjournaal" name="Hypothesis"></textarea> </br> </br>
	</div>
	<div>
		<label for="theory">Theorie:</label> </br>
			<textarea class="groteretextarealabjournaal" name="theory"></textarea> </br> </br>
	</div>
	<div>
		<label for="safety">Veiligheid:</label> </br>
			<textarea class="groteretextarealabjournaal" name="safety"></textarea> </br> </br>
	</div>
	<div>
		<label for="logboek">Logboek:</label> </br>
			<textarea class="groteretextarealabjournaal" name="logboek"></textarea> </br> </br>
	</div>
	<div>
		<label for="method_materials">Methode Materialen:</label> </br>
			<textarea class="groteretextarealabjournaal" name="method_materials"></textarea> </br> </br>
	</div>
	<div>
		<label for="year">Year:</label> </br>
		<label for="1">Leerjaar 1</label>
			<input type="radio" name="year" value="1" checked>
		<label for="1">Leerjaar 2</label>
			<input type="radio" name="year" value="2">
		<label for="1">Leerjaar 3</label>
			<input type="radio" name="year" value="3"> </br> </br>
	</div>
	<div>
		<label for="fileupload">Upload file:</label> </br>
			<input type="file" name="fileupload"> </br> </br>
	</div>	
	<div>
		<input type="submit" name="submit" value="Submit">
		<input type="reset" name="reset" value="Reset"> </br>
	</div>
</form>
</div>
<?php
if(isset($_POST['submit'])){
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
?>