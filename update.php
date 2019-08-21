<?php

// header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Headers: access");
// header("Access-Control-Allow-Methods: GET,PUT,DELET,POST");
// header("Access-Control-Allow-Credentials: true");
// header('Content-Type: application/json');

include 'dbconnection.php';

$idValue = filter_var($_POST['id'], FILTER_SANITIZE_STRING);
$titleValue = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
$authorValue = filter_var($_POST['author'], FILTER_SANITIZE_STRING);
$messagesValue = filter_var($_POST['messages'], FILTER_SANITIZE_STRING);

$status = [
    "status" => "success",
];

$errors = [];

if ($idValue == "" || $idValue == null) {
    $errors['id'] = "id is empty";
}

if (!is_integer((int)$idValue)) {
    $errors['id'] = "id is empty";
}

if ($titleValue == "" || $titleValue == null) {
    $errors['title'] = "title is empty";
}

if ($authorValue == "" || $authorValue == null) {
    $errors['author'] = "author is empty";
}

if ($messagesValue == "" || $messagesValue == null) {
    $errors['messages'] = "messages is empty";
}

if (!empty($errors)) {
    $status['status'] = "error";
    $status['errors'] = $errors;
    echo json_encode($status);
    die;
}

try{
    $sql = "UPDATE notes SET title=:title, author=:author, messages=:messages WHERE id=:id";
    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':id', $id, PDO::PARAM_STR);
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->bindParam(':author', $author, PDO::PARAM_STR);
    $stmt->bindParam(':messages', $messages, PDO::PARAM_STR);
    
    $id = $idValue;
    $title = $titleValue;
    $author = $authorValue;
    $messages = $messagesValue;

    $stmt->execute();

    $status['message'] = "note successfully updated";
    echo json_encode($status);
} catch(PDOException $e){
    die("ERROR: Could not prepare/execute query: $sql. " . $e->getmessages());
}
