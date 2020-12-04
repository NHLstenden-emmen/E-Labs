<div class="docentenHomePage">
    <p>docent home</p>
    <table>
        <tr>
            <th>Name</th>
            <th>Grade</th>
        </tr>
        <?php
        $class = new Database();
        $leerlingen = $class->getAllGradeResults();
        

        //  If sql query found row(with information) -> do this
        
        while ($result = $leerlingen->fetch_array(MYSQLI_ASSOC)){
            $grades = $class->getGradeResultsPerPerson($result['user_id']);

            echo "<tr>";
            echo "<td>" . $result['name'] . "</td>";
        
            //  Switch for displaying digit & correct background color
            while ($grade = $grades->fetch_array(MYSQLI_ASSOC)){
                $cijfer = $grade['grade'];
                $cijferTitel = $grade['title'];
                switch ($cijfer) {
                    case $cijfer <= 5.4:
                        echo "<td class='onvoldoende'>" .  $cijferTitel . ": " . $cijfer . "</td>";
                        break;
                    case $cijfer >= 5.5 && $cijfer < 7:
                        echo "<td class='voldoende'>" .  $cijferTitel . ": " . $cijfer . "</td>";
                        break;
                    case $cijfer >= 7:
                        echo "<td class='goed'>" .  $cijferTitel . ": " . $cijfer . "</td>";
                        break;
                }
            }

            echo "</tr>";
        }
        ?>
    </table>
</div>