<?php

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

include 'dbconnection.php';

$status = [
    "status" => "success",
    "notes" => [],
];

try{
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
} catch(PDOException $e){
    die("ERROR: Could not prepare/execute query: $sql. " . $e->getmessages());
}

?>
