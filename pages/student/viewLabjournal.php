<?php
	$getLabjournaal = $db->getLabjournal($_GET['id'], $_SESSION['user_id']);
	while ($result = $getLabjournaal->fetch_array(MYSQLI_ASSOC)){ 
		?>
	<form method="post">
		<div class="labjournaalcontainer4delen">
			<div class="smalltextarealabjournaallinks">
				<label for="title" class="titlejaarmargintopviewlabjournaal"><?php echo $lang["TITLE"];?>:</label> </br>
				<p name="title"><?php echo $result['title'];?></p>
			</div>
			<div class="smalltextarealabjournaalrechts">
				<label for="year" class="titlejaarmargintopviewlabjournaal"><?php echo $lang["YEAR"];?>:</label> </br>
				<p><?php echo $result["year"];?></p>
			</div>
		</div>
		<div class="labjournaalcontainer3delen">
			<div class="grotetextarealabjournaallinks">
				<label for="Goal"><?php echo $lang["GOAL"];?>:</label> </br>
				<p name="Goal"><?php echo $result['Goal'];?></p>
			</div>
			<div class="grotetextarealabjournaalmidden">
				<label for="Hypothesis"><?php echo $lang["HYPOTHESIS"];?>:</label> </br>
				<p name="Hypothesis" value="<?php echo $result['Hypothesis'];?>"><?php echo $result['Hypothesis'];?></p>
			</div>
			<div class="grotetextarealabjournaalrechts">
				<label for="theory"><?php echo $lang["THEORY"];?>:</label> </br>
				<p name="theory" value="<?php echo $result['theory'];?>"><?php echo $result['theory'];?></p>
			</div>
			<div class="grotetextarealabjournaallinks">
				<label for="safety"><?php echo $lang["SAFETY"];?>:</label> </br>
				<p name="safety" value="<?php echo $result['safety'];?>"><?php echo $result['safety'];?></p>
			</div>
			<div class="grotetextarealabjournaalmidden">
				<label for="logboek"><?php echo $lang["LOG"];?>:</label> </br>
				<p name="logboek" value="<?php echo $result['log'];?>"><?php echo $result['log'];?></p>
			</div>
			<div class="grotetextarealabjournaalrechts">
				<label for="method_materials"><?php echo $lang["METHOD_MATERIALS"];?>:</label> </br>
				<p name="method_materials" value="<?php echo $result['method_materials'];?>"><?php echo $result['method_materials'];?></p>
			</div>
		</div>
		
		<?php 
			// check if its a img of excel file
			$fileSortCheck = strtolower($result["Attachment"]);
			$file = $result["Attachment"];
			// check if source is a image
			if (preg_match('/(\.jpg|\.png|\.jpeg|\.gif)$/', $fileSortCheck)) {
				echo '<img src="'.$file.'" alt="" srcset="">';
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
				# just a check if there is a scoure set.
			} else {
				echo $lang['FILENOTFOUND'];
			}
		?>
	</form>
<?php  }?>