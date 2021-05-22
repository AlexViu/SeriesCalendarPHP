<?php
require "DataBase.php";
$db = new DataBase();
$result = new stdClass();
$result->status = 0;

if ($db->dbConnect()) {
    $result->status = 1;
    $result->response = json_encode($db->series());
} else {
    $result->status = 0;
    $result->message = "Error de conexión";
}

exit(json_encode($result));
?>



