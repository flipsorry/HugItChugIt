<?php
  require_once 'RestRequest.php';
  $rest = new RestRequest();
  $getTorrentsUrl = 'http://localhost:8088/json/torrents';
  $pauseUrl = 'http://localhost:8088/command/pause';
  
  $params = array();
  
  $torrentResult = $rest->makeRequest('GET', $getTorrentsUrl, $params);

  $torrents = json_decode($torrentResult, true);
  
  if (count($torrents) > 0) {
    foreach ($torrents as $index => $torrent) {
      if ($torrent['progress'] == 1
          && strpos($torrent['state'], 'pause') === false ) {
        echo "stopping torrent: " . $torrent['name'];
        $params = array(
          'hash' => $torrent['hash']
        );
        $rest->makeRequest('POST', $pauseUrl, $params);
      }
    }
  }
?>
