<?php

include 'dbconnection.php';

$json = file_get_contents('php://input');
$data = json_decode($json);

$idValue = filter_var($data->id, FILTER_SANITIZE_STRING);
$titleValue = filter_var($data->title, FILTER_SANITIZE_STRING);
$authorValue = filter_var($data->author, FILTER_SANITIZE_STRING);
$messagesValue = filter_var($data->messages, FILTER_SANITIZE_STRING);

$status = [
    "status" => "success",
    "notes" => [],
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
} catch(PDOException $e){
    die("ERROR: Could not prepare/execute query: $sql. " . $e->getmessages());
}

try {
    $sql = "SELECT * FROM notes ORDER BY id ASC";
    $stmt = $pdo->prepare($sql);

    $stmt->execute();
    $notes = $stmt->fetchAll();

    foreach ($notes as $note) {
        array_push($status['notes'], [
            'id' => $note['id'],
            'title' => $note['title'],
            'author' => $note['author'],
            'messages' => $note['messages'],
        ]);
    }

    echo json_encode($status);
} catch (PDOException $e) {
    die("ERROR: Could not prepare/execute query: $sql. " . $e->getmessages());
}
