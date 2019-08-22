<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");
header('Content-Type: application/json');
header("Access-Control-Allow-Methods: Content-Type");

include 'dbconnection.php';

$titleValue = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
$authorValue = filter_var($_POST['author'], FILTER_SANITIZE_STRING);
$messagesValue = filter_var($_POST['messages'], FILTER_SANITIZE_STRING);

$status = [
    "status" => "success",
];

$errors = [];


//validate 

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
    $sql = "INSERT INTO notes (title, author, messages) VALUES (:title, :author, :messages)";
    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->bindParam(':author', $author, PDO::PARAM_STR);
    $stmt->bindParam(':messages', $messages, PDO::PARAM_STR);
    
    $title = $titleValue;
    $author = $authorValue;
    $messages = $messagesValue;

    $stmt->execute();

    $status['message'] = "note successfully created";
    echo json_encode($status);
} catch(PDOException $e){
    die("ERROR: Could not prepare/execute query: $sql. " . $e->getmessages());
}
