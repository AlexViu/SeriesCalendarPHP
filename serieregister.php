<?php
require "DataBase.php";
$db = new DataBase();
$result = new stdClass();
$result->status = 0;

if (isset($_POST['name']) && isset($_POST['platform']) && isset($_POST['description'])) {
    if ($db->dbConnect()) {
        if ($db->SerieRegister("serie", $_POST['name'], $_POST['platform'], $_POST['description'])) {
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