<?php
//required files
  require __DIR__.'/../config/connect.php';
  require __DIR__.'/../controller/shortUrl.php';
  
if (isset($_POST['submit'])) {
//Get form inputs
	$url = trim($_POST['url']);
//open database connection
    $database = new dbConnect(); 
    $db = $database->openConnection(); 
//declare url main segment
    $prefix = BASE_URL ;
//instantiate a new instance of conn
    $item = new shortUrl($db);
//Process long URL
    if (!empty($url)){
        try {
        $short_url = $item->encodeurl($url);
        $url = $prefix.$short_url;
//Output To User
   		$response = array(
            "type" => "success",
            "message" => "Proccessed Successfully...<i class='fa fa-spinner fa-spin'></i>",
            "short_url" => "$url"
        ); 
    } catch (Exception $e) {
        echo $e->getMessage();
        }
    }else{
        $response = array(
            "type" => "error",
            "message" => "Error Proccessing...<i class='fa fa-spinner fa-spin'></i>"
        );
    }
    $database->closeConnection();  //Close Connection
}

?>