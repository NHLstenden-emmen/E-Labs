<?php
	$userID = $_SESSION['user_id'];
    $selectCurrentUsers = $db->selectCurrentUsers($userID);
    echo "<table width='100%' border='1'>";
    echo "<tr><th>naam</th><th>email</th><th>role</th><th>profiel bewerken</th></tr>";
    while ($result = $selectCurrentUsers->fetch_array(MYSQLI_ASSOC)){
        echo "<td>" . $result['name'] . "</td>";
        echo "<td>" . $result['email'] . "</td>";
        echo "<td>" . $result['role'] . "</td>";
        echo "<td> <a href='editprof?id=" . $result['user_id'] . "'>edit</a></td></tr>";
    }
    echo "</table>";
?>