<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Request-Headers: *");
header("Access-Control-Allow-Methods: *");
header('Content-Type: application/json');
header("Access-Control-Allow-Methods: Content-Type");

// header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Headers: access");
// header("Access-Control-Allow-Methods: GET,PUT,DELET,POST");
// header("Access-Control-Allow-Credentials: true");
// header('Content-Type: application/json');

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