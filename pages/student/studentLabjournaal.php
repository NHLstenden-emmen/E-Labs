<div id="labjournaalContainer">
	<p id="newLabjournal">
		<a href="#">+ Nieuw Labjournaal</a>
	</p>
	<div id="mainContainer" class="row">
		<div id="yearNav" class="col-xs-12 col-sm-3 col-lg-2">
			<a href="#">- Jaar 1</a>
			<a href="#">- Jaar 2</a>
			<a href="#">- Jaar 3</a>
		</div>
		<div id="labjournalTable" class="col-xs-12 col-sm-9 col-lg-9">
			<table>
				<?php
					$allLabjournals = $db->selectAllLabjournals();
					// if() {
						// $year = 1;
					// } elseif() {
							// $year = 2;
					// } else {
							// $year = 3;
					// }
					$labjournals = [
						[
							"title" => "titel 1",
							"datum" => "10-20-20",
							"cijfer" => 5
						],
						[
							"title" => "titel 2",
							"datum" => "10-20-20",
							"cijfer" => NULL
						]
					]

				?>
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


