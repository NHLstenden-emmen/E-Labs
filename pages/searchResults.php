<div id="searchResultContainer">
	<?php
		// When session is available getting the user id from session
		$userId = $_SESSION['user_id'];
		if(!empty($_POST['searchInput'])) {
			$searchWord = $_POST['searchInput'];
		} else {
			$searchWord = "";
		}
		// Get every labjournal of the choosen year
		if($_SESSION['role'] == "Student") {
			$allResultsLabjournal = $db->selectStudentSearchResultsLabjournal($userId, "%" . $searchWord . "%");
			$allResultsPreperation = $db->selectStudentSearchResultsPreperation($userId, "%". $searchWord . "%");
		} elseif($_SESSION['role'] == "Docent"){
			// $allResults = $db->selectTeacherSearchResults($userId);
		}
	?>

	<div id="searchResultTable" class="col-xs-12 col-sm-9 col-lg-9">
		<?php
			if($allResultsLabjournal->num_rows !== 0){
		?>
			<table>
			<h3>Gezocht op: <?php echo $searchWord?></h3>
			<h4>Labjournaal</h4>
			<th>Titel</th>
			<th>Datum</th>
			<th>Cijfer</th>
			<th>Acties</th>
			<?php
				while($searchResults = $allResultsLabjournal->fetch_array(MYSQLI_ASSOC)){
					echo "<tr>";
					echo "<td>$searchResults[title]</td>";
					echo "<td>$searchResults[date]</td>";
					if($searchResults['grade'] == NULL ) {
						echo "<td>-</td>";
					} else {
						echo "<td>$searchResults[grade]</td>";
					}
					echo "<td id='actionButtons'>
							<a href='#'><i class='far fa-edit'></i></a>
							<a href='#'><i class='fas fa-eye'></i></a>
							<a href='#'><i class='fas fa-print'></i></a>
						</td>";
					echo "</tr>";
				}	
				echo "</table>";
			}

			if($allResultsPreperation->num_rows !==0) {
			?>
				<h4>Voorbereiding</h4>
				<table>
				<th>Titel</th>
				<th>Datum</th>
				<th>Cijfer</th>
				<th>Acties</th>
			<?php
				while($searchResults = $allResultsPreperation->fetch_array(MYSQLI_ASSOC)){
					echo "<tr>";
					echo "<td>$searchResults[title]</td>";
					echo "<td>$searchResults[date]</td>";
					if($searchResults['grade'] == NULL ) {
						echo "<td>-</td>";
					} else {
						echo "<td>$searchResults[grade]</td>";
					}
					echo "<td id='actionButtons'>
							<a href='#'><i class='far fa-edit'></i></a>
							<a href='#'><i class='fas fa-eye'></i></a>
							<a href='#'><i class='fas fa-print'></i></a>
						</td>";
					echo "</tr>";
				}
				echo "</table>";
			}
		?>
	</div>
</div>