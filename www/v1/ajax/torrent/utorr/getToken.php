<?php
  include('./httpful.phar');
  require_once 'RestRequest.php';
  $rest = new RestRequest();
  $getTokenUrl = 'http://localhost:1080/gui/token.html';
  $indexUrl = 'http://localhost:1080/gui/web/index.html';
  
  $params = array();
  
  # TODO this really needs to be read from DB or input from the client side
  #var_dump(getallheaders());
  $headers = getallheaders();
  #$results = $rest->makeAuthRequest('GET', "flipsorry", "hinesward", $getTokenUrl, $params, $headers);
  $headers["Cookie"] = "";

  $indexResults = $rest->makeAuthRequest('GET', "flipsorry", "hinesward", $indexUrl, $params, $headers);

  $cookies = $indexResults->getResponseMessage()->getHeaders()["Set-Cookie"];
  $headers["Cookie"] = $cookies;

  $results = $rest->makeAuthRequest('GET', "flipsorry", "hinesward", $getTokenUrl, $params, $headers);

  #echo "1<br /><br />";
  #echo $headers["Cookie"];
  #echo $indexResults->getResponseMessage()->getHeaders()["Set-Cookie"];
  #var_dump($results->getResponseMessage()->getHeaders());
  #echo "foo";
  #preg_match('/GUID=(.*);/', $guid, $matches);
  #$guid = $matches[1];
  #echo $guid;

  $body = $results->getResponseBody();

  preg_match('/\<div.*none;\'\>(.*)\<\/div\>\<\/html\>/', $body, $matches);

  $token = $matches[1];

  #header("Set-Cookie: " . $guid);
  #setcookie("token", $token, time() + (86400 * 30), "/");
  $cookiesEncoded = urlencode($cookies . ($cookies ? "; " : "") . "token=$token; sessions=%7B%7D");
  #header("Set-Cookie: token=$token; sessions=%7B%7D");
  #header("Set-Cookie: " . urldecode($cookiesEncoded));
  setcookie("token", $token);
  setcookie("sessions", "{}");
  if ($cookies) {
    $splitcookies = explode(";", $cookies);
    #var_dump($splitcookies);
    foreach ($splitcookies as $cookie) {
      $cookiesplit = explode("=", $cookie);
      #var_dump($cookiesplit);
      setcookie(trim($cookiesplit[0]), urlencode($cookiesplit[1]));
    }
  }

  echo "{\"token\": \"$token\", \"cookies\": \"$cookiesEncoded\"}";

?>
