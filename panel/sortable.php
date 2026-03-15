<?php
include('../config.php');
$data = json_decode(file_get_contents("php://input"), true);

if ($data) {
    foreach ($data as $row) {
        $id = intval($row['id']);
        $position = intval($row['position']);
        if ($row['dir']) {
            $db->query("UPDATE $img_table SET pos = ? WHERE id = ? AND dir = ?", $position, $id, $row['dir']);
        } else {
            $db->query("UPDATE $table SET pos = ? WHERE id = ? AND pos <> 0", $position, $id);
        }
    }
    echo "OK";
}
