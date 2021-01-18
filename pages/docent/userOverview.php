<div class="Gebruikersoverzichtdocent">
    <?php
    $selectAllUsers = $db->selectAllUsers();
    
    if(isset($_GET['sorting'])) {
        if($_GET['sorting'] == "name"){
            $sorting = "name";
            if($_GET['ad'] == "ASC") {
                $ascdesc = "DESC";
            } elseif($_GET['ad'] == "DESC") {
                $ascdesc = "ASC";
            }
        } elseif($_GET['sorting'] == "role") {
            $sorting = "role";
            if($_GET['ad'] == "ASC") {
                $ascdesc = "DESC";
            } elseif($_GET['ad'] == "DESC") {
                $ascdesc = "ASC";
            }
        } elseif($_GET['sorting'] == "email") {
            $sorting = "email";
            if($_GET['ad'] == "ASC") {
                $ascdesc = "DESC";
            } elseif($_GET['ad'] == "DESC") {
                $ascdesc = "ASC";
            }
        
        }
        $selectAllUsers = $db->selectAllUsers2($sorting, $ascdesc);
    
        
    } else {
        // Set default value
        $sorting = "name";
        $ascdesc = "DESC";

        // Gets every labjournal of the choosen year
        $selectAllUsers = $db->selectAllUsers2($sorting, $ascdesc);
    }

    echo "<div class='tableoverzichtdocent'>";
    echo "<table>";
    echo "<tr id='blauwerand'>
            <th id='wittetekst'>" . $lang['NAME'] . "
                <a href='?sorting=name&ad=" . $ascdesc . "'class='icon-block tableHeaderIcons'>
                    <i class='fas fa-sort'></i>
                </a>
            </th>
            <th id='wittetekst'>" . $lang['E-MAIL'] . "
                <a href='?sorting=email&ad=" . $ascdesc . "'class='icon-block tableHeaderIcons'>
                    <i class='fas fa-sort'></i>
                </a>
            </th>
            <th id='wittetekst'>" . $lang['ROLE'] . "
                <a href='?sorting=role&ad=" . $ascdesc . "'class='icon-block tableHeaderIcons'>
                    <i class='fas fa-sort'></i>
                </a>
            </th>
            <th id='wittetekst'>" . $lang['EDIT_PROFILE'] . "</th>
        </tr>";
    while($allResults = $selectAllUsers->fetch_array(MYSQLI_ASSOC)){
                       if($allResults['role'] != "DELETED"){
                        echo "<td>".$allResults['name']."</td>";
                        echo "<td>".$allResults['email']."</td>";
                        echo "<td>".$allResults['role']."</td>";
                        echo "<td> <a href='editaccount?id=" . $allResults['user_id'] . "'>".$lang['EDIT'] ."</a>";
                        echo "&nbsp;&nbsp;";
                        if($allResults['user_id'] !== $_SESSION['user_id']){
                        echo "<a href='deleteaccount?id=".$allResults['user_id']."'>" .$lang['DEL']."</a>";}
                        echo "</td></tr>";}
                    }
                    echo "</table>";
               
?>
</div>
</div>