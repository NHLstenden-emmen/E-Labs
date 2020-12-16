<?php
    $selectAllUsers = $db->selectAllUsers();
    echo "<table width='100%' border='1'>";
    echo "<tr>
            <th>".$lang['NAME']."</th>
            <th>".$lang['E-MAIL']."</th>
            <th>".$lang['ROLE']."</th>
            <th>".$lang['EDIT_PROFILE']."</th>
        </tr>";
    while ($result = $selectAllUsers->fetch_array(MYSQLI_ASSOC)){
        if($result['role'] != "DELETED"){
        echo "<td>" . $result['name'] . "</td>";
        echo "<td>" . $result['email'] . "</td>";
        echo "<td>" . $result['role'] . "</td>";
        echo "<td> <a href='acountbewerken?id=" . $result['user_id'] . "'>".$lang['EDIT'] ."</a>";
        echo "&nbsp;&nbsp;";
        if($result['user_id'] !== $_SESSION['user_id']){
        echo "<a href='accountverwijderen?id=".$result['user_id']."'>" .$lang['DEL']."</a>";}
        echo "</td></tr>";}
    }
    echo "</table>";
?>