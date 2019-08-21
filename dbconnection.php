<?php
header("Access-Control-Allow-Origin: *");

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