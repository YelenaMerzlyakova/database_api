# Read me database_api

Published API : <https://elena-notes-api.herokuapp.com/>

possible extensions to the API :

* read.php
* list.php
* delete.php
* ...

The mission was to create an API that can save notes and later on to add a web interface for it ([see my note-app-front-end repository](https://github.com/YelenaMerzlyakova/vue-app)).

The learning objectives were : 

* Using MySQL databases
* The difference between SQL and NoSQL
* CRUD
* Understanding HTTP request types
* Pull requests and reviews

I have used a SQL database (mySQL, phpmyadmin) because it was better structured. Checkout my other repositories for a project with a NoSQL database. 

## Preview 

![api](https://github.com/YelenaMerzlyakova/database_api/blob/master/notesapi.png)


## Code 

create a note 

```
PHP
<?php
include 'dbconnection.php';
$json = file_get_contents('php://input');
$data = json_decode($json);
$titleValue = filter_var($data->title, FILTER_SANITIZE_STRING);
$authorValue = filter_var($data->author, FILTER_SANITIZE_STRING);
$messagesValue = filter_var($data->messages, FILTER_SANITIZE_STRING);
$status = [
    "status" => "success",
    "notes" => [],
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





