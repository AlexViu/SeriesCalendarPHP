<?php
require "DataBase.php";
$db = new DataBase();
$result = new stdClass();
$result->status = 0;

if (isset($_POST['id_usuario'])) {
    
    if ($db->dbConnect()) {
        $result->status = 1;
        $result->response = json_encode($db->getFavorite($_POST['id_usuario']));
    } else {
        $result->status = 0;
        $result->message = "Error de conexión";
    }
} else {
    $result->status = 0;
    $result->message = "All fields are required";
}

exit(json_encode($result));
?>
