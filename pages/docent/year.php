<div class="docentenHomePage">
    <table>
        <tr>
            <th><?php echo $lang["NAME"];?></th>
            <th><?php echo $lang["GRADE"];?></th>
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
                $cijferTitel = $labjournaal['title'];
                $labjournaalID = $labjournaal['labjournaal_id'];
                
                switch ($cijfer) {
                    case $cijfer <= 5.4:
                        echo "<td class='onvoldoende'> <a href='labjournaalview?labjournaal=".$labjournaalID."'>" .  $cijferTitel . ": " . $cijfer . "</a></td>";
                        break;
                    case $cijfer >= 5.5 && $cijfer < 7:
                        echo "<td class='voldoende'> <a href='labjournaalview?labjournaal=".$labjournaalID."'>" .  $cijferTitel . ": " . $cijfer . "</a></td>";
                        break;
                    case $cijfer >= 7:
                        echo "<td class='goed'> <a href='labjournaalview?labjournaal=".$labjournaalID."'>" .  $cijferTitel . ": " . $cijfer . "</a></td>";
                        break;
                }
            }

            echo "</tr>";
        }
        ?>
    </table>
</div>