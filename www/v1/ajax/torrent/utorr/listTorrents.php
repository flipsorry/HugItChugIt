<?php
  include('./httpful.phar');
  require_once 'RestRequest.php';
  $rest = new RestRequest();
  $token = $_COOKIE["token"];
  #$cookies = $_GET["cookies"];
  $getUrl = "http://192.168.1.160:1080/gui/?token=$token&list=1";

  $params = array();

  # TODO this really needs to be read from DB or input from the client side
  $headers = getallheaders();
  #$headers["Cookie"] = $cookies;
  #$headers["Referer"] = "http://192.168.1.125:1080/gui/web/index.html";
  #$headers["Cookie"] = $headers["Cookie"] . "; sessions=%7B%7D; path=/";
  #var_dump($headers["Cookie"]);

  $results = $rest->makeAuthRequest('GET', "flipsorry", "hinesward", $getUrl, $params, $headers);
  echo $results->getResponseBody();



?>
