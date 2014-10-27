<?php
  require_once 'RestRequest.php';
  $rest = new RestRequest();
  $method = $_GET["method"];
  $url = 'http://localhost:8088' . $_GET["url"];
  
  $params = array();
  
  foreach ($_GET as $key => $value) { 
  	if (strcmp($key, 'method') !== 0 && strcmp($key, 'url') !== 0) {
  		$params[$key] = htmlspecialchars($value);
  	}
  }
  
  echo $rest->makeRequest($method, $url, $params);
?>
