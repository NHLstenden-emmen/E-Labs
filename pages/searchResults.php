<div id="searchResultContainer">
	<?php
		// When session is available getting the user id from session
		$userId = $_SESSION['user_id'];
		if(!empty($_POST['searchInput'])) {
			$searchWord = $_POST['searchInput'];

			// Check which role the user has and gets the labjournals and/or preperations which contains the searched word
			if($_SESSION['role'] == "Student") {
				$allResultsLabjournal = $db->selectStudentSearchResultsLabjournal($userId, "%" . $searchWord . "%");
				$allResultsPreperation = $db->selectStudentSearchResultsPreperation($userId, "%". $searchWord . "%");
			} elseif($_SESSION['role'] == "Docent"){
				$allResultsLabjournal = $db->selectTeacherSearchResultsLabjournal("%" . $searchWord . "%");
				$allResultsPreperation = $db->selectTeacherSearchResultsPreperation("%". $searchWord . "%");
			}
	?>
			<div id="searchResultTable" class="col-xs-12 col-sm-9 col-lg-9">
			<?php
			if($allResultsLabjournal->num_rows == 0 && $allResultsPreperation->num_rows == 0){
				echo "<h4 id='noResultsText'>Geen zoekresultaat gevonden voor: ". $searchWord ."</h4>";
			} else {
				if($allResultsLabjournal->num_rows !== 0){
				?>
				<table>
					<h3><?php echo $lang['SEARCHEDFOR']." ".$searchWord?></h3>
					<h4><?=$lang['LABJOURNAL'];?></h4>
					<th><?=$lang['TITLE'];?></th>
					<th><?=$lang['DATE'];?></th>
					<th><?=$lang['GRADE'];?></th>
					<th><?=$lang['ACTION'];?></th>
				<?php
					while($searchResults = $allResultsLabjournal->fetch_array(MYSQLI_ASSOC)){
						echo "<tr>";
						echo "<td>".$searchResults['title']."</td>";
						echo "<td>".$searchResults['date']."</td>";
						if($searchResults['grade'] == NULL ) {
							echo "<td>-</td>";
						} else {
							echo "<td>".$searchResults['grade']."</td>";
						}
						echo "<td class='actionButtons'>";

						if($searchResults['submitted'] == 0) {
							echo "<a href='EditJournal?id=" . $searchResults['labjournal_id'] . "'><i class='far fa-edit'></i></a>";
						} else {
							echo "<a href='viewLabjournal?id=" . $searchResults['labjournal_id'] . "'><i class='fas fa-eye'></i></a>";
						}
						echo "<a href='pdf?labjournaal_id=". $searchResults['labjournal_id']."' target='_blank'>  <i class='fas fa-print'></i></a>
							</td>";
						echo "</tr>";	
					}
					echo "</table>";
				}

				if($allResultsPreperation->num_rows !==0) {
				?>
					<h4><?=$lang['PREPARATIONS'];?></h4>
					<table>
					<th><?=$lang['TITLE'];?></th>
					<th><?=$lang['DATE'];?></th>
					<th><?=$lang['GRADE'];?></th>
					<th><?=$lang['ACTION'];?></th>
				<?php
					while($searchResults = $allResultsPreperation->fetch_array(MYSQLI_ASSOC)){
						echo "<tr>";
						echo "<td>".$searchResults['title']."</td>";
						echo "<td>".$searchResults['date']."</td>";
						if($searchResults['grade'] == NULL ) {
							echo "<td>-</td>";
						} else {
							echo "<td>".$searchResults['grade']."</td>";
						}
						echo "<td class='actionButtons'>";
						if ($searchResults['submitted'] == 0) {
							echo "<a href='EditJournal?id=" . $searchResults['preparation_id'] . "'><i class='far fa-edit'></i></a>";
						} else{
							echo "<a href='viewLabjournal?id=" . $searchResults['preparation_id'] . "'><i class='fas fa-eye'></i></a>";
						}
						echo "<a href='pdf?preparation_id=" . $searchResults['preparation_id'] . "' target='_blank'>  <i class='fas fa-print'></i></a>
							</td>";
						echo "</tr>";	
					}
					echo "</table>";
				}
			}
		} else {
			echo "<h4 id='noResultsText'>".$lang['NOSEARCHWORDFOUND']."</h4>";
		}

		?>
	</div>
</div>