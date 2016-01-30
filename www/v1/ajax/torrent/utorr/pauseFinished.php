<?php
  include('./httpful.phar');
  require_once 'RestRequest.php';
  $rest = new RestRequest();
  $getTokenUrl = 'http://localhost:1080/gui/token.html';
  $indexUrl = 'http://localhost:1080/gui/web/index.html';
  $params = array();
  $headers = getallheaders();
  $indexResults = $rest->makeAuthRequest('GET', "flipsorry", "hinesward", $indexUrl, $params, $headers);
  $cookies = $indexResults->getResponseMessage()->getHeaders()["Set-Cookie"];
  $headers["Cookie"] = $cookies;
  $results = $rest->makeAuthRequest('GET', "flipsorry", "hinesward", $getTokenUrl, $params, $headers);
  $body = $results->getResponseBody();
  preg_match('/\<div.*none;\'\>(.*)\<\/div\>\<\/html\>/', $body, $matches);
  $token = $matches[1];

  $getUrl = "http://localhost:1080/gui/?token=$token&list=1"; 
  
  $results = $rest->makeAuthRequest('GET', "flipsorry", "hinesward", $getUrl, $params, $headers);

  $torrents = json_decode($results->getResponseBody(), true)['torrents'];
  #var_dump($torrents);
  if (count($torrents) > 0) {
    foreach ($torrents as $index => $torrent) {
      if ($torrent[4] == 1000
          && strcmp($torrent[21], 'Seeding') === 0 ) {
        #echo "stopping torrent: " . $torrent[2];
        $pauseUrl = "http://localhost:1080/gui/?token=$token&action=stop&hash=" . $torrent[0];
        echo "stopping torrent: " . $torrent[2] . ". Url: $pauseUrl";
        $results = $rest->makeAuthRequest('GET', "flipsorry", "hinesward", $pauseUrl, $params, $headers);
      }
    }
  }
?>
