<!DOCTYPE html>
<html>
    <head>
    <link rel="stylesheet" href="style.css">
        <title> Docenten Pagina </title>
    </head>
<body>
    <p>docent home</p>
    <table>
        <tr>
            <th>Name</th>
            <th>Grade</th>
        </tr>
        <?php
        //  Set DB username
        DEFINE("DB_USER", "root");
        //  Set DB password
        DEFINE("DB_PASS", "");
        //  Try to make a connection to the DB
        try {
            $db = new PDO("mysql:host=localhost;dbname=e-labs",DB_USER,DB_PASS);
            $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo $e->getMessage();
        }

        //  Get value's for column
        $sql = "SELECT DISTINCT users.user_id, users.name, lab_journal.grade
                FROM users
                INNER JOIN lab_journal_users ON users.user_id = lab_journal_users.user_id
                INNER JOIN lab_journal ON lab_journal.labjournaal_id = lab_journal_users.lab_journal_id
                GROUP BY users.user_id";

        // Get value's for the grades
        $sql2 = "SELECT lab_journal.grade, lab_journal.title
                FROM users
                INNER JOIN lab_journal_users ON users.user_id = lab_journal_users.user_id
                INNER JOIN lab_journal ON lab_journal.labjournaal_id = lab_journal_users.lab_journal_id
                WHERE users.user_id = ?";

        //  Execute $sql query
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $leerlingen = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //  If sql query found row(with information) -> do this
        if ($leerlingen) {

            //  Loop array $leerlingen from executed query as $leerling
            foreach($leerlingen as $leerling) {

                //  Get user_id's from array $leerling
                $stmt2 = $db->prepare($sql2);
                $stmt2->execute(array($leerling["user_id"]));
                $grades = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                //  Start the table-row
                echo "<tr>";

                echo "<td>" . $leerling['name'] . "</td>";

                //  Re-loop(Grades ONLY) for multiple grade's in column, from exectured query
                foreach($grades as $grade) {

                    //  Put looped value's in variables
                    $cijfer = $grade['grade'];
                    $cijferTitel = $grade['title'];

                    //  Switch for displaying digit & correct background color
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

                // End the table-row
                echo "</tr>";
            }
        }
        ?>
    </table>
</body>
</html>
