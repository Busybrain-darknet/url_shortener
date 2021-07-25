<?php
/**
 * July 2021
 * Class for URL shortner
 */
class shortUrl
{
//Setting Environment Functionality
	//Declaring variables 
    protected static $urlExists = false;        
    protected $timestamp;
    //Database Connection
    private $con;
    private $db_table = "url_info";

    //Function to construct pdo interface for connection
    public function __construct($db){
        $this->con = $db;
        $this->timestamp = date("y-m-d H:i:s");
    }

//Encode URL
	//Function to check and process URL input
	public function encodeurl($url){
		//check if URL is empty
		if (empty($url)) {
			// show user error
			throw new Exception("URL Missing!");	
		}
		//check URL format
		if ($this->validateUrl($url) == false) {
			// show user error
			throw new Exception("Invalid URL Format!");	
		}
		//Checking URL in our records
		$short_url = $this->urlExistsInDB($url);
		if ($short_url == false) {
			// code...
			$short_url = $this->createShortUrl($url);
		}
		// Return result...
		return $short_url;
	}

	//Function to validate URL
	protected function validateUrl($url){
		// Return result...
		return filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_HOST_REQUIRED);
	}

	//Function to check URL in our records
	protected function urlExistsInDB($url){
		// Fetch and verify if the record already exists...
		$query = "SELECT short_url FROM " . $this->db_table ." WHERE long_url = :long_url LIMIT 1";
		$stmt = $this->con->prepare($query);
		$urlinfo = array(
			'long_url' => $url 
		);
		$stmt->execute($urlinfo);
		$result = $stmt->fetch();
		// Return result...
		return (empty($result)) ? false : $result["short_url"];
	}

	//Function to Create Short URL
	//This can still be more elaborate using basecode_64
	protected function createShortUrl($url)
	{
		// Derive the short code by shuffle...
		$length = 6;
    	$chars = "1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
		$short_url = substr(str_shuffle($chars), 0, $length);
		base64_encode($short_url);
		//Insert 
		$id = $this->insertUrlInDB($url, $short_url);
		// Return result...
		return $short_url;
	}


	//Function to save short URL into Database
	protected function insertUrlInDB($url, $code)
	{
		// Insert The Information...
		$query = "INSERT INTO " . $this->db_table . " (long_url, short_url, created) VALUES (:long_url, :short_url, :timestamp)";
		$stmnt = $this->con->prepare($query);
		$data = array(
			"long_url" => $url,
			"short_url" => $code,
			"timestamp" => $this->timestamp
		); 
		$stmnt->execute($data);
		//Create 100 byte of shared memory block with system id of oxff3
		$shm_key = shmop_open(0xff3, "c", 0644, 100);
		//check if block was allocated
		if (!$shm_key) echo "Memory could not be allocated";
		shmop_write($shm_key, serialize($data), 0);
		
		// Return result...
		return $this->con->lastInsertId();
	}
//End Encode URL	

//Decode URL  
	//get url and process it
    public function decodeUrl($url, $increment = true){
    	//checking if sent URL
    	if (empty($url)) {
    		// code...
    		throw new Exception("No URL Given");	
    	}
		$urlRow = $this->getUrlInDB($url);
		if ($urlRow == false) {
			// code...
			throw new Exception("No Such Record");	
		}
    	//return result
    	return $urlRow;
    }

    //get the url from database 
    protected function getUrlInDB($url)
    {
    	// Fetch record of long url...
    	$query = "UPDATE ". $this->db_table ." SET hits = hits + 1 WHERE short_url = :short_url";
    	$stmt = $this->con->prepare($query);
    	$stmt->bindParam(':short_url', $url);
    	//Get statistics of the URL
		if ($stmt->execute()) {
		$query = "SELECT long_url FROM " . $this->db_table ." WHERE short_url = :short_url LIMIT 1";
    	$stmt = $this->con->prepare($query); 
    	$stmt->bindParam(':short_url', $url);
		$stmt->execute();
		$urlRow = $stmt->fetch();
		}
		//return result
		return (empty($urlRow)) ? false : $urlRow["long_url"]; 
    }
//End Decode URL

//Statistics Of The URL
    //get url and process it
    public function statsUrl($url){
    	//checking if sent data is empty
    	if (empty($url)) {
    		// code...
    		throw new Exception("No URL Given");	
    	}
    	//checking url records
    	$urlRow = $this->countUrlInDB($url);
    	if (empty($urlRow)) {
    		// code...
    		throw new Exception("This URL Does Not Exist");		
    	}
    	//return result
    	var_dump($urlRow);
    }

        //get the url from database 
    protected function countUrlInDB($url)
    {
    	// Fetching record of long url...
    	$query = "SELECT long_url, hits, created FROM " . $this->db_table ." WHERE short_url = :short_url LIMIT 1";
    	$stmt = $this->con->prepare($query);
    	$data = array(
			"short_url" => $url
		); 
		$stmt->execute($data);
		//Using the result to get statistics of the URL
		$urlRow = $stmt->fetchAll();	
		//return result
		return $urlRow; 
    }

}