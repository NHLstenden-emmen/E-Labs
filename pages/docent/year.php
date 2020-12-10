<div class="docentenHomePage">
    <table>
        <tr>
            <th><?php echo $lang["NAME"];?></th>
            <th><?php echo $lang['TITLE'];?></th>
            <th><?php echo $lang["GRADE"];?></th>
            <th><?php echo $lang["ACTION"];?></th>
        </tr>
        <?php
        if(isset($_GET['year'])) {
            if($_GET['year'] == 2) {
                $year = 2;
            } elseif ($_GET['year'] == 3) {
                $year = 3;
            } else {
                $year = 1;
            }
        } else {
            $year = 1;
        }

        $leerlingen = $db->getAllGradeResults($year);

        //  If sql query found row(with information) -> do this
        while ($result = $leerlingen->fetch_array(MYSQLI_ASSOC)){
            $labjournaals = $db->getGradeResultsPerPerson($result['user_id'], $year);

            echo "<tr>";
            echo "<td>" . $result['name'] . "</td>";
        
            //  Switch for displaying digit & correct background color
            while ($labjournaal = $labjournaals->fetch_array(MYSQLI_ASSOC)){
                $cijfer = $labjournaal['grade'];
                $title = $labjournaal['title'];
                $labjournaalID = $labjournaal['labjournaal_id'];
                echo "<td>".$title."</td>";
                
                switch ($cijfer) {
                    case $cijfer <= 5.4:
                        echo "<td class='onvoldoende'>".$cijfer."</td>";
                        break;
                    case $cijfer >= 5.5 && $cijfer < 7:
                        echo "<td class='voldoende'>".$cijfer."</td>";
                        break;
                    case $cijfer >= 7:
                        echo "<td class='goed'>".$cijfer."</td>";
                        break;
                }
                echo "<td>
                        <a href='labjournaalview?labjournaal=".$labjournaalID."'TITLE='".$lang['VIEWLAB']."'><i class='fas fa-eye'></i></a>
                        <a href ='unknown?labjournaal=".$labjournaalID."'TITLE='".$lang['GRADELAB']."'><i class='far fa-edit'></i></a>
                        <a href='pdf?labjournaal_id=".$labjournaalID."target='_blank' TITLE='".$lang['PRINTLAB']."'><i class='fas fa-print'></i></a>
                    </td>";
            }

            echo "</tr>";
        }
        ?>
    </table>
</div>