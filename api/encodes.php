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
//declare url main segment
    $prefix = BASE_URL ;
//instantiate a new instance of conn
    $item = new shortUrl($db);
//Accept json format
    $link = json_decode(file_get_contents("php://input"), true);
    $url = $link['url'];  
//Process short URL 
    if (!empty($url)){
        try {
        $short_url = $item->encodeurl($url);
        $url = $prefix.$short_url;
        echo json_encode($url);
        } catch (Exception $e) {
        //output error
        echo $e->getMessage();
        }
    }
    $database->closeConnection(); //Close Connection
?>