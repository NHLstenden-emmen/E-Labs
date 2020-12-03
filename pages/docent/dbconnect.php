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
?>