<?php
    $selectAllUsers = $db->selectAllUsers();
    echo "<table width='100%' border='1'>";
    echo "<tr>
            <th>".$lang['NAME']."</th>
            <th>".$lang['ROLE']."</th>
            <th>".$lang['EDIT_PROFILE']."</th>
            <th>".$lang['E-MAIL']."</th>
        </tr>";
    while ($result = $selectAllUsers->fetch_array(MYSQLI_ASSOC)){
        echo "<td>" . $result['name'] . "</td>";
        echo "<td>" . $result['email'] . "</td>";
        echo "<td>" . $result['role'] . "</td>";
        echo "<td> <a href='editprof?id=" . $result['user_id'] . "'>".$lang['EDIT']."</a></td></tr>";
    }
    echo "</table>";
?>