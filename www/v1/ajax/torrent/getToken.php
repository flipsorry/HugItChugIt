<?php
  include('./httpful.phar');
  require_once 'RestRequest.php';
  $rest = new RestRequest();
  $getTokenUrl = 'http://192.168.1.160:1080/gui/token.html';
  
  $params = array();
  
  # TODO this really needs to be read from DB or input from the client side
  #var_dump(getallheaders());
  $results = $rest->makeAuthRequest('GET', "flipsorry", "hinesward", $getTokenUrl, $params, getallheaders());
  $guid = $results->getResponseMessage()->getHeaders()["Set-Cookie"];
  

  #preg_match('/GUID=(.*);/', $guid, $matches);
  #$guid = $matches[1];

  $body = $results->getResponseBody();

  preg_match('/\<div.*none;\'\>(.*)\<\/div\>\<\/html\>/', $body, $matches);

  $token = $matches[1];

  header("Set-Cookie: " . $guid);
  setcookie("token", $token, time() + (86400 * 30), "/");

  echo "{\"token\": \"$token\"}";

?>
