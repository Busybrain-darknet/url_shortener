<?php
//required files
    require __DIR__.'/../config/connect.php';
    require __DIR__.'/../controller/shortUrl.php';
//Declare headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
//open database connection
    $database = new dbConnect();
    $db = $database->openConnection(); 
//instantiate a new instance of conn
    $item = new shortUrl($db); 
//Accept json format
    $link = json_decode(file_get_contents("php://input"), true);   
    $seg = $link['url']; //Works With The Base URL Only
    $url = explode("/", parse_url($seg, PHP_URL_PATH));
//Process long URL
    if (!empty($url = $url[3]))
        try {
        $url1 = $item->statsUrl($url);
        stripslashes(json_encode($url1)); 
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    $database->closeConnection(); //Close Database
?>