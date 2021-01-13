<?php
if(isset($_GET['labjournal'])) {
	$labjournalid = $_GET['labjournal'];
} else {
	$labjournalid = 'not found';
}

if(isset($_POST['changeGrade'])){
	if ($_POST['grade'] <= 10 && $_POST['grade'] >= 0) {
		$grade = $_POST['grade'];
		$db->updateGradeView($labjournalid, $grade);
		echo $lang['GRADECHANGED'];
	} else {
		echo $LANG['WRONGGRADE'];
	}
}
if(isset($_POST['archive'])){
	$db->archiveLabjournal($_GET['labjournal'], 2);
}
if(isset($_POST['deArchive'])){
	$db->archiveLabjournal($_GET['labjournal'], 1);
}

$labjournal = $db->teacherLabjournalView($labjournalid);
?>

<?php
	while ($result = $labjournal->fetch_array(MYSQLI_ASSOC)){
		echo "<h1 class='labjournaaltitle'>" . $result['title'] . "</h1>";
		?>
		<div class="labjournaalcontainer4delen"> 
		<?php
		echo "<div class='smalltextarealabjournaallinks'><h4>".$lang['NAME'].": </h4><p>" . $result['name'] . "</p></div>";
		echo "<div class='smalltextarealabjournaalrechts'><h4>".$lang['DATE'].": </h4><p>" . $result['date'] . "</p></div>";
		echo "</div><div class='labjournaalcontainer3delen'>";
		echo "<div class='grotetextarealabjournaallinks'><h4>".$lang['GOAL'].": </h4><p>" . $result['Goal'] . "</p></div>";
		echo "<div class='grotetextarealabjournaalmidden'><h4>".$lang['HYPOTHESIS'].": </h4><p>" . $result['Hypothesis'] . "</p></div>";
		echo "<div class='grotetextarealabjournaalrechts'><h4>".$lang['MATERIALS'].": </h4><p>" . $result['method_materials'] . "</p></div>";
		echo "<div class='grotetextarealabjournaallinks'><h4>".$lang['THEORY'].": </h4><p>" . $result['theory'] . "</p></div>";
		echo "<div class='grotetextarealabjournaalmidden'><h4>".$lang['SAFETY'].": </h4><p>" . $result['safety'] . "</p></div>";
		echo "<div class='grotetextarealabjournaalrechts'><h4>".$lang['LOG'].": </h4><p>" . $result['log'] . "</p></div>";
		echo "</div>";
		echo "<div class='labjournaalcontainer4delen'>";
			echo "<div class='bestandlabjournaaltoegevoegd'>";
			// check if its a img of excel file
			$fileSortCheck = strtolower($result["Attachment"]);
			$file = $result["Attachment"];
			// check if source is a image
			if (preg_match('/(\.jpg|\.png|\.jpeg|\.gif)$/', $fileSortCheck)) {
				echo '<img src="'.$file.'" alt="" class="bestandlabjournaaltoegevoegdwidth" srcset="">';
				// check if source is a csv format from excel.
			} else if (preg_match('/(\.csv)$/', $fileSortCheck)){
					echo "<br>";
					echo "<table>\n\n";
						$f = fopen($file, "r");
						while (($line = fgetcsv($f)) !== false) {
							echo "<tr>";
							foreach ($line as $cell) {
								echo "<td style='border: 1px solid black;'>" . htmlspecialchars($cell) . "</td>";
							}
							echo "</tr>\n";
						}
						fclose($f);
					echo "\n</table>";
			} else if (empty($result["Attachment"])){
				# just a check if there is a source set.
			} else {
				echo $lang['FILENOTFOUND'];
			}
			echo "</div>";
		echo '</div>';	
		echo "</div><div class='labjournaalcontainer3delen'>";
		echo "<div class='grotetextarealabjournaalmidden'><h4>".$lang['GRADE'].": </h4>
		<form method='POST'>
			<input type='text' name='grade' class='labjournaalboxcijfer' value=" .$result['grade'] . ">
			<input type='submit' name='changeGrade' class='labjournaalbuttoncijfer' value =".$lang['CHANGEGRADE'].">
		</form>
		</div>
		<div class='grotetextarealabjournaalmidden'>";
		if ($result['submitted'] == 2) {
			echo "<form method='POST'>
					<input type='submit' value='Dearchive' name='deArchive' class='labjournaalbuttonarchive'>
				</form>";
		} else {
			echo "<form method='POST'>
					<input type='submit' value='Archive' name='archive' class='labjournaalbuttonarchive'>
				</form>";
		}
		echo "</div></div>";
	}
?>
