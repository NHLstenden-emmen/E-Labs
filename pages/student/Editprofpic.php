<?php
	$userID = $_SESSION['user_id'];
    $selectCurrentUsers = $db->selectCurrentUsers($userID);

    while ($result = $selectCurrentUsers->fetch_array(MYSQLI_ASSOC)){
		echo "<form method='post' action='update?id=". $result['user_id'] ,"' enctype='multipart/form-data'> ";
        echo "<td><img src=" . $result['profile_picture'] ."></td>";
		echo "<td><input name='profpic' type='file'</td><br>";
		echo "<td><input value='Update' type='submit'</td><br>";
        }
    echo "</form>";
?>