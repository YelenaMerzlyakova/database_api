<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
// slect the http request method
$http_method = $_SERVER["REQUEST_METHOD"];
    
    //  CONNECT TO DATABASE
    try {
        $db = parse_url(getenv("DATABASE_URL"));
        $pdo = new PDO("pgsql:" . sprintf(
            "host=%s;port=%s;user=%s;password=%s;dbname=%s",
            $db["ec2-54-75-238-138.eu-west-1.compute.amazonaws.com"],
            $db["5432"],
            $db["tlibxanabpjoji"],
            $db["3b568cf6dbd780af495f05a764429036af92b9f1ce6ae341fd692a70c259e22a"],
            ltrim($db["path"], "/")
        ));
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die(json_encode(["error message"=>"Connection failed: " . $e->getMessage()]));
    }