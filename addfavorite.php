<?php
require "DataBase.php";
$db = new DataBase();
$result = new stdClass();
$result->status = 0;

if (isset($_POST['id_usuario']) && isset($_POST['id_serie'])) {
    if ($db->dbConnect()) {
        if ($db->addFavorite("user_serie", $_POST['id_usuario'], $_POST['id_serie'])) {
            $result->status = 1;
        } else {
            $result->status = 0;
			$result->message = "No se ha podido registrar";
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