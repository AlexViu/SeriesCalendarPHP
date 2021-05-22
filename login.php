<?php
require "DataBase.php";
$db = new DataBase();
$result = new stdClass();
$result->status = 0;

if (isset($_POST['username']) && isset($_POST['password'])) {
    if ($db->dbConnect()) {
        if ($db->logIn("usuario", $_POST['username'], $_POST['password'])) {
           $result->status = 1;
        } else {
            $result->status = 0;
            $result->message = "Username o password incorrectos";
        }
    } else {
        $result->status = 0;
        $result->message = "Error: Database connection";
    }
} else {
    $result->status = 0;
    $result->message = "All fields are required";
}

exit(json_encode($result));
?>
