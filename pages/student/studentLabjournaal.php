<div id="labjournaalContainer">
	<p id="newLabjournal">
		<a href="#">+ Nieuw Labjournaal</a>
	</p>
	<div id="mainContainer" class="row">
		<div id="yearNav" class="col-xs-12 col-sm-3 col-lg-2">
			<a href="?year=1">- Jaar 1</a>
			<a href="?year=2">- Jaar 2</a>
			<a href="?year=3">- Jaar 3</a>
		</div>
		<div id="labjournalTable" class="col-xs-12 col-sm-9 col-lg-9">
			<table>
				<?php
					if(isset($_GET['year'])) {
						if($_GET['year'] == 2) {
							$year = 2;
						} elseif ($_GET['year'] == '3') {
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
				<h3><?php echo "Overzicht jaar " . $year; ?></h3>
				<th>Titel</th>
				<th>Datum</th>
				<th>Cijfer</th>
				<th>Acties</th>
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
								<a href='#'><i class='fas fa-print'></i></a>
							</td>";
						echo "</tr>";
					}	
				?>
					
			</table>
		</div>
	</div>
</div>


<?php
	// Bewerk icon disabelen wanneer labjournaal al verstuurt is.
?>