<?php
  require_once 'RestRequest.php';
  $rest = new RestRequest();
	$magnet = htmlspecialchars($_GET["magnet"]);
  $token = $_GET["token"];
  $url = "http://192.168.1.160:1080/command/download";
  
  $data = array('urls' => $magnet, 'token' => $token);

  $url = "http://192.168.1.160:1080/gui?list=1&token=" . $token;
 
  $results = $rest->makeAuthRequest('GET', "flipsorry", "hinesward", $url, array(), getallheaders());

  #var_dump($results);

  $body = $results->getResponseBody();
  if (preg_match('/invalid request/', $results->getResponseBody())) {
    header('HTTP/1.0 403 Forbidden');
    die('Invalid token');
  }
  echo json_encode(array('response' => $body));

?>
