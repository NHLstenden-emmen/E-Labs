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
        ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <label for="sortDate">Sorteer de datum</label>
                <select name="sortOptionDate" id="sortOptionDate" onchange="document.getElementById('textDate').value=this.options[this.selectedIndex].text; this.form.submit()">
                <?php
                    if(isset($_POST['sortOptionName'])){
                    ?>
                        <option selected value="<?php echo $_POST['sortOptionDate']; ?>"><?php echo $_POST['textDate']; ?></option>
                    <?php
                    }else{
                    ?>
                        <option selected value="">Selecteer een sorteer optie</option>
                    <?php
                    }
                    ?>
                    <option value="ASC">Datum oud-nieuw</option>
                    <option value="DESC">Datum nieuw-oud</option>
                </select>
                <input type="hidden" name="textDate" id="textDate" value="" />
                <label for="sortName">Sorteer de naam</label>
                <select name="sortOptionName" id="sortOptionName" onchange="document.getElementById('textName').value=this.options[this.selectedIndex].text; this.form.submit()">
                    <?php
                    if(isset($_POST['sortOptionName'])){
                    ?>
                        <option selected value="<?php echo $_POST['sortOptionName']; ?>"><?php echo $_POST['textName']; ?></option>
                    <?php
                    }else{
                    ?>
                        <option selected value="">Selecteer een sorteer optie</option>
                    <?php
                    }
                    ?>
                    <option value="ASC">Naam A-Z</option>
                    <option value="DESC">Naam Z-A</option>
                </select>
                <input type="hidden" name="textName" id="textName" value="" />

                <input type='hidden' name="submit" id='submit' value="submit">
                <input type="submit" name='submitButton' id='submitButton' value='submit'>
        </form>
        <?php
        if(isset($_POST['submit'])){
            $sortName = $_POST['sortOptionName'];
            $leerlingen = $db->getAllGradeResults($year,$sortName);
        } else {
            $leerlingen = $db->getAllGradeResults($year,'');
        }

        //  If sql query found row(with information) -> do this
        while ($result = $leerlingen->fetch_array(MYSQLI_ASSOC)){

            if(isset($_POST['submit'])){
                $sortDate = $_POST['sortOptionDate'];
                $labjournaals = $db->getGradeResultsPerPerson($result['user_id'], $year, $sortDate);
            } else {
                $labjournaals = $db->getGradeResultsPerPerson($result['user_id'], $year, '');
            }

            echo "<tr>";
            echo "<td>" . $result['name'] . "</td>";
        
            //  If-Else for displaying digit & correct background color
            while ($labjournaal = $labjournaals->fetch_array(MYSQLI_ASSOC)){
                $cijfer = $labjournaal['grade'];
                $cijferTitel = mb_strimwidth($labjournaal['title'], 0, 15, "...");
                $labjournaalID = $labjournaal['labjournaal_id'];
                if($cijfer >= 1 && $cijfer <= 5.4) {
                    echo "<td class='onvoldoende'> <a href='labjournaalview?labjournaal=".$labjournaalID."'>" .  $cijferTitel . ": " . '-' . "</a></td>";
                } elseif($cijfer >= 5.5 && $cijfer <= 10) {
                    echo "<td class='goed'> <a href='labjournaalview?labjournaal=".$labjournaalID."'>" .  $cijferTitel . ": " . $cijfer . "</a></td>";
                } else {
                    echo "<td class='nietbeoordeeld'> <a href='labjournaalview?labjournaal=".$labjournaalID."'>" .  $cijferTitel . ": " . $cijfer . "</a></td>"; 
                }
            }

            echo "</tr>";
        }
        ?>
    </table>
</div>