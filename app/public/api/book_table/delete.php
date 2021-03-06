<?php

try {
    $_POST = json_decode(
        file_get_contents('php://input'),
        true,
        2,
        JSON_THROW_ON_ERROR
    );
} catch (Exception $e) {
    header($_SERVER["SERVER_PROTOCOL"] . "400 Bad Request");
    exit;
}

require("class/DbConnection.php");

$db = DbConnection::getConnection();

$stmt = $db->prepare(
    'DELETE FROM book_table WHERE ID = ?'
);

$stmt->execute([
        $_POST['ID']
    ]);

header('HTTP/1.1 303 See Other');
header('Location: ../book_table/');