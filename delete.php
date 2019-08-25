<?php

include 'dbconnection.php';

$idValue = filter_var($_GET['id'], FILTER_SANITIZE_STRING);

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

if (!empty($errors)) {
    $status['status'] = "error";
    $status['errors'] = $errors;
    echo json_encode($status);
    die;
}

try{
    $sql = "DELETE FROM notes WHERE id = :id";
    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':id', $id, PDO::PARAM_STR);
    
    $id = $idValue;

    $stmt->execute();

    $status['messages'] = "note successfully deleted";
    echo json_encode($status);
} catch(PDOException $e){
    die("ERROR: Could not prepare/execute query: $sql. " . $e->getmessages());
}