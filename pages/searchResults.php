<div id="searchResultContainer">
	<?php
		// When session is available getting the user id from session
		$userId = $_SESSION['user_id'];
		if(!empty($_GET['searchInput'])) {
			$input = $_GET['searchInput'];
		} else {
			$input = "";
		}
		// Get every labjournal of the choosen year
		// if($_SESSION['role'] == "student") {
		// 	$allResults = $db->selectStudentSearchResults($userId);
		// } else {
		// 	$allResults = $db->selectTeacherSearchResults($userId);
		// }
	?>

		<div id="searchResultTable" class="col-xs-12 col-sm-9 col-lg-9">
			<table>
				<h3>Gezocht op: <?php echo $input?></h3>
				<th>Titel</th>
				<th>Datum</th>
				<th>Cijfer</th>
				<th>Acties</th>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<?php

					// while($searchResults = $allResults->fetch_array(MYSQLI_ASSOC)){
					// 	echo "<tr>";
					// 	echo "<td>$serachResults[title]</td>";
					// 	echo "<td>$searchResults[date]</td>";
					// 	if($searchResults['grade'] == NULL ) {
					// 		echo "<td>-</td>";
					// 	} else {
					// 		echo "<td>$searchResults[grade]</td>";
					// 	}
					// 	echo "<td id='actionButtons'>
					// 			<a href='#'><i class='far fa-edit'></i></a>
					// 			<a href='#'><i class='fas fa-eye'></i></a>
					// 			<a href='#'><i class='fas fa-print'></i></a>
					// 		</td>";
					// 	echo "</tr>";
					// }	
				?>
					
			</table>
		</div>

</div>