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
    'UPDATE book_table SET 
        Title = ?, 
        Author = ?, 
        Year_Published = ?, 
        Publisher = ?, 
        Page_Count = ?, 
        MSRP = ?
    WHERE ID = ?'
);

$stmt->execute([
        $_POST['Title'],
        $_POST['Author'],
        $_POST['Year_Published'],
        $_POST['Publisher'],
        $_POST['Page_Count'],
        $_POST['MSRP'],
        $_POST['ID']
    ]);

header('HTTP/1.1 303 See Other');
header('Location: ../book_table/');