<div id="labjournaalContainer">
	<p id="newLabjournal">
		<a href="createNewLabjournaal">+ <?php echo $lang["NEW_LAB_JOURNAL"];?></a>
	</p>
	<div id="mainContainer" class="row">
		<div id="yearNav" class="col-xs-12 col-sm-3 col-lg-2">
			<a href="?year=1">- <?php echo $lang["YEAR_1"];  ?></a>
			<a href="?year=2">- <?php echo $lang["YEAR_2"];  ?></a>
			<a href="?year=3">- <?php echo $lang["YEAR_3"];  ?></a>
		</div>
		<div id="labjournalTable" class="col-xs-12 col-sm-9 col-lg-9">
			<table>
				<?php
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
					$userId = $_SESSION['user_id'];

					// Get every labjournal of the choosen year
					$allLabjournals = $db->selectAllLabjournals($year, $userId);
				?>
				<h3><?php echo $lang["YEAR_OVERVIEW"] . $year; ?></h3>
				<th><?php echo $lang["TITLE"];?></th>
				<th><?php echo $lang["DATE"];?></th>
				<th><?php echo $lang["GRADE"];?></th>
				<th><?php echo $lang["ACTION"];?></th>
				<?php
					while($allResults = $allLabjournals->fetch_array(MYSQLI_ASSOC)){
						echo "<tr>";
						echo "<td>$allResults[title]</td>";
						echo "<td>$allResults[date]</td>";
						if($allResults['grade'] == NULL ) {
							echo "<td>-</td>";
						} else {
							echo "<td>$allResults[grade]</td>";
						}
						echo "<td id='actionButtons'>
								<a href='#'><i class='far fa-edit'></i></a>
								<a href='#'><i class='fas fa-eye'></i></a>
								<a href='pdf?labjournaal_id=$allResults[labjournaal_id]' target='_blank'><i class='fas fa-print'></i></a>
							</td>";
						echo "</tr>";
					}	
				?>
					
			</table>
		</div>
	</div>
</div>