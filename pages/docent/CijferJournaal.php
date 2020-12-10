<?php
$labjournaal_id = $_GET['labjournaal_id'];



				if(isset($_GET['year'])) {
					if($_GET['year'] == 2) {
						$year = 2;
					} elseif ($_GET['year'] == 3) {
						$year = 3;
					} else {
						$year = 1;
					}
				} else {
					$year = 1;
				}

				// Get every labjournal of the choosen year
    		$output = $db->selectcontentlabjournal($labjournaal_id);
    		while ($outputarray = $output->fetch_array(MYSQLI_ASSOC)){
				$title = $outputarray['title'];
				$date = $outputarray['date'];
				$grade = $outputarray['grade'];
			?>
			<pre><p>Title: &#9; <?php echo "$title" ?></p>
			<p>Date: &#9; <?php echo "$date" ?></p>
			<form method='post' enctype='multipart/form-data'>
			<p>Grade</p><p><input type="text" name="title" value="<?php echo "$grade" ?>"/></p>
			 <p><input name="submit" type="submit" value="Submit"/></p>
			</form>
			</pre>
			<?php
			
						
						if($grade == NULL ) {
							echo "";
						} else {
							echo "<td>$grade</td>";
						}
						if(isset($_POST['submit'])){
						$yes = $db->updatelabjournaal($labjournaal_id, $title, $date, $grade);
						var_dump($yes);
}
						echo "</tr>";
					}	
				?>
