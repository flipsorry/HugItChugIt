<?php
  include('./httpful.phar');
  require_once $_SERVER['DOCUMENT_ROOT'] . '/v1/data/mysql/ConvertVideoDao.php';
  require_once 'RestRequest.php';
  $convertVideoDao = new ConvertVideoDao();
  $rest = new RestRequest();
  $getTokenUrl = 'http://localhost:1080/gui/token.html';
  $indexUrl = 'http://localhost:1080/gui/web/index.html';
  $params = array();
  $headers = getallheaders();
  # First get the token to utserve
  $indexResults = $rest->makeAuthRequest('GET', "flipsorry", "hinesward", $indexUrl, $params, $headers);
  $cookies = $indexResults->getResponseMessage()->getHeaders()["Set-Cookie"];
  $headers["Cookie"] = $cookies;
  $results = $rest->makeAuthRequest('GET', "flipsorry", "hinesward", $getTokenUrl, $params, $headers);
  $body = $results->getResponseBody();
  preg_match('/\<div.*none;\'\>(.*)\<\/div\>\<\/html\>/', $body, $matches);
  $token = $matches[1];

  # Now get all of the open torrents
  $getUrl = "http://localhost:1080/gui/?token=$token&list=1"; 
  $results = $rest->makeAuthRequest('GET', "flipsorry", "hinesward", $getUrl, $params, $headers);

  $resultsJson = json_decode($results->getResponseBody(), true);
  $torrents = $resultsJson['torrents'];
  $cid = $resultsJson['torrentc'];
  if (count($torrents) > 0) {
    foreach ($torrents as $index => $torrent) {
      # Find any "Seeding" torrents
      if ($torrent[4] == 1000
          && strcmp($torrent[21], 'Seeding') === 0 ) {
        $getFilesUrl = "http://localhost:1080/gui/?token=$token&action=getfiles&cid=$cid&hash=" . $torrent[0];
        echo "getFilesUrl: $getFilesUrl\n";
        $getFilesResults = $rest->makeAuthRequest('GET', "flipsorry", "hinesward", $getFilesUrl, $params, $headers);
        $filesJson = json_decode($getFilesResults->getResponseBody(), true);
        $files = $filesJson['files'][1];
        # Go through all the files to see if we need to convert any
        foreach ($files as $index => $file) {
          $fileName = $file[0];
          $sizeMb = $file[1] / 1000000;
          preg_match("/\.mkv/", $fileName, $mkvMatches);
          preg_match("/\.avi/", $fileName, $aviMatches);
          $isMkv = ! empty($mkvMatches);
          $isAvi = ! empty($aviMatches);
          # If we have a mkv file or avi file that is bigger than 20mb, then let's convert
          if ($sizeMb > 20 && ($isMkv || $isAvi)) {
            $filePath = $torrent[26] . "/" . $fileName;
            $outputFile = "$filePath.mp4";
            $logFile = "/var/log/flipsorry/convert/$fileName";
            $formatType = $isMkv ? "mkv" : "avi";
            echo "inputFile: $filePath\n";
            echo "outputFile: $outputFile\n";
            echo "logFile: $logFile\n";
            echo "formatType: $formatType\n";
            $audioStreamIndex="1";
            # If this is an mkv, find out if the audio for english is not in the first slot
            if ($isMkv) {
              $avprobe = shell_exec("avprobe -show_streams -of json '$filePath'");
              $streams = json_decode($avprobe, true)['streams'];
              foreach ($streams as $index => $stream) {
                echo $stream['index'] . " - " . $stream['codec_type'] . "\n";
                if ($stream['index'] != 0 
                    && strcmp($stream['codec_type'], 'audio') === 0
                    && ! empty($stream['tags'])
                    && ! empty($stream['tags']['language'])
                    && strcmp($stream['tags']['language'], 'eng') === 0) {
                  $audioStreamIndex = $stream['index'];
                }
              }
            }
            $additionalArgs = "{\"audioStreamIndex\": $audioStreamIndex}";
            echo "additionalArgs: $additionalArgs";
            $convertVideoDao->putRequest($fileName, $filePath, $outputFile, $logFile, $formatType, $additionalArgs);
          }
        }
        # Now stop the seeding
        $pauseUrl = "http://localhost:1080/gui/?token=$token&action=stop&hash=" . $torrent[0];
        echo "\nstopping torrent: " . $torrent[2] . ". Url: $pauseUrl\n\n";
        $results = $rest->makeAuthRequest('GET', "flipsorry", "hinesward", $pauseUrl, $params, $headers);
      }
    }
  }
?>
