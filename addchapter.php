<?php
require "DataBase.php";
$db = new DataBase();
$result = new stdClass();
$result->status = 0;

if (isset($_POST['number_chapter']) && isset($_POST['name']) && isset($_POST['id_season']) && isset($_POST['description']) && isset($_POST['date'])) {
    if ($db->dbConnect()) {
        if ($db->addChapter("chapter", $_POST['number_chapter'], $_POST['name'], $_POST['id_season'], $_POST['description'], $_POST['date'])) {
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