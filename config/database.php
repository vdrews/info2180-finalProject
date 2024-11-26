<?php

// Yours may differ so change it as you seem fit...
$db_server = "localhost";
$db_username = "root";
$db_password = "root";
$db_name = "dolphin_crm";

try{
    $conn = mysqli_connect($db_server, $db_username, $db_password, $db_name);

    if(!$conn){
        echo "Connection failed";
    }

    //Comment it out if you need to
    //mysqli_close($conn);
} catch (mysqli_sql_exception $ex) {
    echo "Could not connect to database.\n";
}
