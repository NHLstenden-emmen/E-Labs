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

// check if you need to search in archive or not
if(isset($_GET['archive'])) {
    if (isset($_GET['changeArchive'])) {
        if($_GET['archive'] != "true") {
            $archive = "true";
            $submitted = 2;
        } else {
            $archive = "false";
            $submitted = 1;
        }
    } else {
        if($_GET['archive'] == "true") {
            $archive = "true";
            $submitted = 2;
        } else {
            $archive = "false";
            $submitted = 1;
        }
    }
} else {
    $archive = "false";
    $submitted = 1;
}

// Checks if sorting is set and checks value of it
if(isset($_GET['sorting'])) {
    if($_GET['sorting'] == "name"){
        $sorting = "name";
        $ascdescDate = $_GET['datesort'];
        if($_GET['namesort'] == "ASC") {
            $ascdesc = "DESC";
        } elseif($_GET['namesort'] == "DESC") {
            $ascdesc = "ASC";
        }
    } elseif($_GET['sorting'] == "date") {
        $sorting = "date";
        $ascdesc = $_GET['namesort'];
        if($_GET['datesort'] == "ASC") {
            $ascdescDate = "DESC";
        } elseif($_GET['datesort'] == "DESC") {
            $ascdescDate = "ASC";
        }
    }
    // Gets every labjournal of the choosen year 
        $leerlingen = $db->getAllGradeResults($year,$submitted,$ascdesc);
} else {
    $sorting = "name";
    $ascdesc = "DESC";
    $ascdescDate = "DESC";
    // Set default value

    $leerlingen = $db->getAllGradeResults($year,$submitted,$ascdesc);
}
?>
<div class="docentenHomePage">
<h1><?=$lang['OVERVIEWLABJOURNALS'];?></h1>
<h4>
    <a href="?year=<?php echo $year?>&archive=<?php echo $archive?>&changeArchive">
        <?php if ($archive == "false") {
            echo $lang['TOARCHIVE'];
        } else {
            echo $lang['GOBACKOVERVIEW'];
        }
        ?>
    </a>
 </h4>
    <table>
        <tr>
            <th><a href="?year=<?php echo $year ?>&sorting=name&namesort=<?php echo $ascdesc?>&datesort=<?php echo $ascdescDate?>&archive=<?php echo $archive?>" class="icon-block tableHeaderIcons">
                    <?php echo $lang["NAME"];?>
                    <i class="fas fa-sort"></i>
                </a>
                <a href="?year=<?php echo $year ?>&sorting=date&namesort=<?php echo $ascdesc?>&datesort=<?php echo $ascdescDate?>&archive=<?php echo $archive?>" class="icon-block tableHeaderIcons">
                    <?php echo $lang["DATE"];?>
                    <i class="fas fa-sort"></i>
                </a>
            </th>
        </tr>
        <?php

        //  If sql query found row(with information) -> do this
        while ($result = $leerlingen->fetch_array(MYSQLI_ASSOC)){

            if($sorting == "date"){
                $labjournals = $db->getGradeResultsPerPerson($result['user_id'], $year,$submitted, $ascdescDate);
            } else {
                $labjournals = $db->getGradeResultsPerPerson($result['user_id'], $year,$submitted, '');
            }

            echo "<tr>";
            echo "<td>" . $result['name'] . "</td>";
        
            //  If-Else for displaying digit & correct background color
            while ($labjournal = $labjournals->fetch_array(MYSQLI_ASSOC)){
                $cijfer = $labjournal['grade'];
                $cijferTitel = mb_strimwidth($labjournal['title'], 0, 15, "...");
                $labjournalID = $labjournal['labjournal_id'];
                if($cijfer >= 1 && $cijfer <= 5.4) {
                    echo "<td class='onvoldoende'> <a href='labjournalview?labjournal=".$labjournalID."'>" .  $cijferTitel . ": " . $cijfer . "</a></td>";
                } elseif($cijfer >= 5.5 && $cijfer <= 10) {
                    echo "<td class='goed'> <a href='labjournalview?labjournal=".$labjournalID."'>" .  $cijferTitel . ": " . $cijfer . "</a></td>";
                } else {
                    echo "<td class='nietbeoordeeld'> <a href='labjournalview?labjournal=".$labjournalID."'>" .  $cijferTitel . ":. " . $cijfer." </a></td>"; 
                }
            }

            echo "</tr>";
        }
        ?>
    </table>
</div>