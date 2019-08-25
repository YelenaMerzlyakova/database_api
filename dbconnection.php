<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");
header('Content-Type: *');
header("Access-Control-Allow-Methods: *");

// slect the http request method
$http_method = $_SERVER["REQUEST_METHOD"];

//  CONNECT TO DATABASE
try {
    $db = parse_url(getenv("DATABASE_URL"));
    $pdo = new PDO("pgsql:" . sprintf(
        "host=%s;port=%s;user=%s;password=%s;dbname=%s",
        $db["host"],
        $db["port"],
        $db["user"],
        $db["pass"],
        ltrim($db["path"], "/")
    ));
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die(json_encode(["error message"=>"Connection failed: " . $e->getMessage()]));
}

// $servername = "mysql";
// $database = "database";
// $username = "user";
// $password = "password";

// try {
//     $pdo = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
//     // set the PDO error mode to exception
//     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// } catch (PDOException $e) {
//     echo "Connection failed: " . $e->getMessage();
// }