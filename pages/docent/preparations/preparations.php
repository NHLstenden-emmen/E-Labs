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
        $leerlingen = $db->getAllPreparationsGradeResults($year, $submitted, $sorting, $ascdesc);
} else {
    // Set default value
    $sorting = "date";
    $ascdesc = "DESC";
    $leerlingen = $db->getAllPreparationsGradeResults($year,$submitted, $sorting, $ascdesc);
}
?>
<div class="docentenHomePage">
    <a href='?year=1<?php if($archive == "true"){ echo "&archive=true";}?>'><?php echo $lang["YEAR"]." 1";?></a> | 
    <a href='?year=2<?php if($archive == "true"){ echo "&archive=true";}?>'><?php echo $lang["YEAR"]." 2";?></a> | 
    <a href='?year=3<?php if($archive == "true"){ echo "&archive=true";}?>'><?php echo $lang["YEAR"]." 3";?></a>
<h1><?=$lang['ALLPREPARATIONS'];?></h1>
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
            <th><?php echo $lang["NAME"];?><a href="?year=<?php echo $year?>&sorting=name&ad=<?php echo $ascdesc?>&archive=<?php echo $archive?>" class="icon-block tableHeaderIcons"><i class="fas fa-sort"></i></a></th>
            <th><?php echo $lang["DATE"];?><a href="?year=<?php echo $year?>&sorting=date&ad=<?php echo $ascdesc?>&archive=<?php echo $archive?>" class="icon-block tableHeaderIcons"><i class="fas fa-sort"></i></a></th>
            <th><?php echo $lang["TITLE"];?><a href="?year=<?php echo $year?>&sorting=title&ad=<?php echo $ascdesc?>&archive=<?php echo $archive?>" class="icon-block tableHeaderIcons"><i class="fas fa-sort"></i></a></th>
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
            // If else for displaying colors
            if($cijfer >= 1 && $cijfer <= 5.4) {
                echo "<td class='onvoldoende'>". $cijfer . "</td>";
            } elseif($cijfer >= 5.5 && $cijfer <= 10) {
                echo "<td class='goed gradeTextColor'>". $cijfer . "</td>";
            } else {
                echo "<td class='nietbeoordeeld'> ". $cijfer."</td>"; 
            }
            echo "<td> <a href='preparationsview?preparation=".$result['preparation_id']."' class='gradeTextColor'><i class='fas fa-eye'></i></a></td>";
        }
        ?>
		</tr>
    </table>
	</div>
	</div>
</div>