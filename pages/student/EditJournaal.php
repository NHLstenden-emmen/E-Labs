<?php
$userID = $_SESSION['user_id'];
   $selectAllLabjournals = $db->selectAllLabjournals($year, $userID);

    while ($result = $selectAllLabjournals->fetch_array(MYSQLI_ASSOC)){
		echo "<form method='post' action='updateJournaal?id=". $result['user_id'] ,"' enctype='multipart/form-data'> ";
        echo "<td><input type='text'" . $result['title'] ."></td>";
		echo "<td><input name='profpic' type='file'</td><br>";
		echo "<td><input value='Update' type='submit'</td><br>";
        }
    echo "</form>";
	
	?>