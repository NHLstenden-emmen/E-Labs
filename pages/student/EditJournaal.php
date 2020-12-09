<?php
$id = $_GET['id'];



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
				// When session is available getting the user id from session
				$userId = 1;

				// Get every labjournal of the choosen year
				$allLabjournals = $db->selectAllLabjournals($year, $userId);
			?>
			<?php
					while($allResults = $allLabjournals->fetch_array(MYSQLI_ASSOC)){
			?> 
			<form method='post' enctype='multipart/form-data'>
			<p>Title </p><p><input type="text" name="title" value="<?php echo "$allResults[title]" ?>"/></p>
			<p>Date</p><p><input type="text" name="title" value="<?php echo "$allResults[date]" ?>"/></p>
			<p>Grade </p><p><input type="text" name="title" value="<?php echo "$allResults[grade]" ?>"/></p>
			 <p><input name="submit" type="submit" value="Submit" /></p>
			
			<?php
			
						
						if($allResults['grade'] == NULL ) {
							echo "";
						} else {
							echo "<td>$allResults[grade]</td>";
						}
						if(isset($_POST['submit'])){
						$db->updatelabjournaal($_SESSION['user_id'] ,$title, $date, $grade);
}
						echo "</tr>";
					}	
				?>
