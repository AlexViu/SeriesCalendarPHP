<?php
require "DataBase.php";
$db = new DataBase();
$result = new stdClass();
$result->status = 0;

if (isset($_POST['username']) && isset($_POST['comment']) && isset($_POST['id_chapter'])) {
    if ($db->dbConnect()) {
        if ($db->addComment("chapter_comments", $_POST['username'], $_POST['comment'], $_POST['id_chapter'])) {
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