<?PHP
        $DBConnect = mysqli_connect("localhost", "root", "");
        if ($DBConnect === FALSE) {
            echo "<p>Unable to connect to the database
            server.</p>"
            . "<p>Error code " . mysqli_errno() . ": " . mysqli_error()
            . "</p>";
        } else {
            $DBName = "e-labs";
            if (!mysqli_select_db($DBConnect, $DBName)) {
                echo "<p>There are no entries in the guest
            book!</p>";
            } else {
                $TableName = "users";
                $SQLstring = "SELECT * FROM " . $TableName;
                if ($stmt = mysqli_prepare($DBConnect, $SQLstring)) {
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_bind_result($stmt, $id, $name, $email, $usernumber, $password, $profilepic, $lang, $role);
                    mysqli_stmt_store_result($stmt);
                    if (mysqli_stmt_num_rows($stmt) == 0) {
                        echo "<p>There are no entries in the guest book!</p>";
                    } else {
                        echo "<p>The following visitors have signed ourguest book:</p>";
                        echo "<table width='100%' border='1'>";
                        echo "<tr><th>NAAM</th><th>EMAIL </th><th>PROFILE PIC </th></tr>";
                        while (mysqli_stmt_fetch($stmt)) {
                            echo "<td>" . $name . "</td>";
                            echo "<td>" . $email . "</td>";
                            echo "<td>" . $profilepic . "</td>";

                            echo "<td> <a href='Editprofpic.php?id=" . $id . "'>edit</a></td></tr>";
                        }
                    }
                }else{
                  printf("Error: %s.\n", mysqli_stmt_error($stmt));
                }
                mysqli_stmt_close($stmt);
            }
            mysqli_close($DBConnect);
        }
        ?>