<?php
   require __DIR__.'/controller/mode.php';

   //open database connection
    $database = new dbConnect();
    $db = $database->openConnection(); 
//instantiate a new instance of conn
    $item = new shortUrl($db);
//Accept json format
    $link = $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
    $url = explode("/", parse_url($link, PHP_URL_PATH));
//Process long URL
    if (!empty($url = $url[1])){
        try {
        $url1 = $item->decodeUrl($url);
        stripslashes(json_encode($url1)); 
    //Redirect URL    
      header("Location: " .$url1); 
    } catch (Exception $e) {
        echo $e->getMessage();
        }
    }
    $database->closeConnection();  //Close Connection
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>URL Shortner | URL Service</title>
  <meta name="description" content="API for URL Shortner In PHP">
  <meta name="keywords" content="API, URL Shortner, URL System In PHP">
  <meta name="author" content="Oluben">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/icofont/icofont.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
</head>