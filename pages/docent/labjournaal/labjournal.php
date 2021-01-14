<?php 
//checks the year and sets it to the approppriate year
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
        if($_GET['ad'] == "ASC") {
            $ascdesc = "DESC";
        } elseif($_GET['ad'] == "DESC") {
            $ascdesc = "ASC";
        }
    } elseif($_GET['sorting'] == "date") {
        $sorting = "date";
        if($_GET['ad'] == "ASC") {
            $ascdesc = "DESC";
        } elseif($_GET['ad'] == "DESC") {
            $ascdesc = "ASC";
        }
    } elseif($_GET['sorting'] == "title") {
        $sorting = "title";
        if($_GET['ad'] == "ASC") {
            $ascdesc = "DESC";
        } elseif($_GET['ad'] == "DESC") {
            $ascdesc = "ASC";
        }
    }
    // Gets every student of the choosen year 
        $leerlingen = $db->getAllGradeResults($year, $submitted, $sorting, $ascdesc);
} else {
    // Set default value
    $sorting = "date";
    $ascdesc = "DESC";
    $leerlingen = $db->getAllGradeResults($year,$submitted, $sorting, $ascdesc);
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
 <div id="labjournaalContainer">
 <div id="labjournalTable" class="col-xs-12 col-sm-9 col-lg-9">
    <table>
        <tr>
            <th><?php echo $lang["NAME"];?><a href="?sorting=name&ad=<?php echo $ascdesc?>&archive=<?php echo $archive?>" class="icon-block tableHeaderIcons"><i class="fas fa-sort"></i></a></th>
            <th><?php echo $lang["DATE"];?><a href="?sorting=date&ad=<?php echo $ascdesc?>&archive=<?php echo $archive?>" class="icon-block tableHeaderIcons"><i class="fas fa-sort"></i></a></th>
            <th><?php echo $lang["LABTITLE"];?><a href="?sorting=title&ad=<?php echo $ascdesc?>&archive=<?php echo $archive?>" class="icon-block tableHeaderIcons"><i class="fas fa-sort"></i></a></th>
            <th><?php echo $lang["GRADE"];?></th>
            <th><?php echo $lang["ACTION"];?></th>
        </tr>
        <?php

        //  If sql query found row(with information) -> do this
        while ($result = $leerlingen->fetch_array(MYSQLI_ASSOC)){

            echo "<tr>";
            echo "<td>$result[name]</td>";
            echo "<td>$result[date]</td>";
            echo "<td>$result[title]</td>";
            $cijfer = $result['grade'];
            $cijferTitel = mb_strimwidth($result['title'], 0, 15, "...");
            //if else for displaying correct colors
            if($cijfer >= 1 && $cijfer <= 5.4) {
                echo "<td class='onvoldoende'>". $cijfer . "</td>";
            } elseif($cijfer >= 5.5 && $cijfer <= 10) {
                echo "<td class='goed gradeTextColor'>". $cijfer . "</td>";
            } else {
                echo "<td class='nietbeoordeeld'> ". $cijfer."</td>"; 
            }
            echo "<td> <a href='labjournalview?labjournal=".$result['labjournal_id']."' class='gradeTextColor'><i class='fas fa-eye'></i></a></td>";
        }
        ?>
		</tr>
    </table>
	</div>
	</div>
</div>