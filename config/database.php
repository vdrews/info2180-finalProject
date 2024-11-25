<?php

// Yours may differ so change it as you seem fit...
$db_server = "localhost";
$db_username = "root";
$db_password = "root";
$db_name = "dolphin_crm";

try{
    $conn = mysqli_connect($db_server, $db_username, $db_password, $db_name);
} catch (mysqli_sql_exception $ex) {
    echo "Could not connect to database.\n";
}
