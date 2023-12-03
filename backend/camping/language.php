<?php
require_once '../database.php';
$destination = [];
if (isset($_SERVER["CONTENT_TYPE"])) {
    $contentType = $_SERVER["CONTENT_TYPE"];

    if ($contentType == "application/json") {
        $content = trim(file_get_contents("php://input"));
        $decoded = json_decode($content, true);
        if ($decoded["language"] == "en") {
            $item = $database->select(
                "tb_destinations",
                ["tb_destinations.destination_lname", "tb_destinations.destination_description"],
                ["id_destination" => $decoded["id_destination"]]
            );
            $destination["name"] = $item[0]["destination_lname"];
            $destination["description"] = $item[0]["destination_description"];
        } else {
            $item = $database->select(
                "tb_destinations",
                ["tb_destinations.destination_lname_tr", "tb_destinations.destination_description_tr"],
                ["id_destination" => $decoded["id_destination"]]
            );
            $destination["name"] = $item[0]["destination_lname_tr"];
            $destination["description"] = $item[0]["destination_description_tr"];
        }
        echo json_encode($destination);
    }
}
?>