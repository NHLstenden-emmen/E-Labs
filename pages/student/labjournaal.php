<?php
	// Gets the user_id from the session
	$userId = $_SESSION['user_id'];

	// Checks if sorting is set and checks value of it
	if(isset($_GET['sorting'])) {
		if($_GET['sorting'] == "title"){
			$sorting = "title";
			if($_GET['ad'] == "ASC") {
				$ascdesc = "DESC";
			} elseif($_GET['ad'] == "DESC") {
				$ascdesc = "ASC";
			}
		} elseif($_GET['sorting'] == "date") {
			$sorting = "date";
			if($_GET['ad'] == "ASC") {
				$ascdesc = "DESC";
			} elseif($_GET['ad'] == "DESC") {
				$ascdesc = "ASC";
			}
		}
		// Gets every labjournal of the choosen year 
		$allLabjournals = $db->selectAllLabjournals($year, $userId, $sorting, $ascdesc);
	} else {
		// Set default value
		$sorting = "date";
		$ascdesc = "DESC";

		// Gets every labjournal of the choosen year
		$allLabjournals = $db->selectAllLabjournals($year, $userId, $sorting, $ascdesc);
	}
?>

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
			<h3><?php echo $lang["YEAR_OVERVIEW"] . $year; ?></h3>
			<table>
				<tr>
					<th><?php echo $lang["TITLE"];?></th>
					<th><?php echo $lang["DATE"];?></th>
					<th><?php echo $lang["UPLOAD_FILE"];?></th>
// 					<th><?php echo $lang["TITLE"];?><a href="?sorting=title&ad=<?php echo $ascdesc?>" class="icon-block tableHeaderIcons"><i class="fas fa-sort"></i></a></th>
// 					<th><?php echo $lang["DATE"];?><a href="?sorting=date&ad=<?php echo $ascdesc?>" class="icon-block tableHeaderIcons"><i class="fas fa-sort"></i></a></th>
					<th><?php echo $lang["GRADE"];?></th>
					<th><?php echo $lang["ACTION"];?></th>
				</tr>
				<?php
					while($allResults = $allLabjournals->fetch_array(MYSQLI_ASSOC)){
						echo "<tr>";
						echo "<td>$allResults[title]</td>";
						echo "<td>$allResults[date]</td>";
						echo "<td><a href='exel?id=$allResults[labjournaal_id]'>$allResults[Attachment]</a> </td> ";
						if($allResults['grade'] == NULL ) {
							echo "<td>-</td>";
						} else {
							echo "<td>$allResults[grade]</td>";
						}
						echo "<td class='actionButtons'>";
						if ($allResults['submitted'] == 0) {
							echo "&nbsp;<a href='EditJournaal?id=".$allResults['labjournaal_id']."'><i class='far fa-edit'></i></a>";
						} else{
							echo "&nbsp;<a href='viewLabjournaal?id=".$allResults['labjournaal_id']."'><i class='fas fa-eye'></i></a>";
						}
						echo "&nbsp;<a href='pdf?labjournaal_id=$allResults[labjournaal_id]' target='_blank'><i class='fas fa-print'></i></a>
							</td>";
						echo "</tr>";
					}	
				?>
			</table>
		</div>
	</div>
</div>