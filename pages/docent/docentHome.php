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
            <th>User ID</th>
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
        $sql2 = "SELECT lab_journal.grade
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

                echo "<td>" . $leerling['user_id'] . "</td><td>" . $leerling['name'] . "</td>";
                //  Re-loop(Grades ONLY) for multiple grade's in column, from exectured query
                foreach($grades as $grade) {
                    echo "<td>" . $grade['grade'] . "</td>";
                }
                // End the table-row
                echo "</tr>";
            }
        }
        ?>
    </table>
</body>
</html>
