<?php

class HttpRequest {
  public function getTorrentList($search) {
    return $this->callPirateAndProcess($search);
  }

  // Strips out the important information in the line
  private function processLine($line) {
    preg_match("/a href=\"\/torrent.*>(.*)\<\/a>\<\/div>/i", $line, $nameMatch);
    $name = $nameMatch[1];

    preg_match("/a href=\"(magnet[^ ]*)\"/i", $line, $magnetMatch);
    $magnet = urlencode($magnetMatch[1]);

    preg_match("/\<td align=\"right\">([0-9]*)\<\/td>/i", $line, $seedMatch);
    $seeds = $seedMatch[1];
   
    return array('name' => $name, 'magnet' => $magnet, 'seeds' => $seeds);
  }

  private function callPirateAndProcess($search) {
    echo exec("rm wget-test.html");
    fclose($file);

    # echo exec("wget -q -O- http://thepiratebay.se/search/" . urlencode($search) . "/0/7/0 | gunzip > wget-test.html");
    # echo exec("wget -q -O wget-test.html http://oldpiratebay.org/search/" . urlencode($search) . "/0/7/0");
    echo exec("wget -q -O wget-test.html http://oldpiratebay.org/search.php?Torrent_sort=seeders.desc&q=" . urlencode($search)); 
    $file = fopen("wget-test.html", "r") or die("can't open file");
    $webpage = fread($file, filesize("wget-test.html"));
    fclose($file);
    $webpage = preg_replace("/\n/i", "", $webpage);
    $webpage = preg_replace("/(\/tr>)/i", "$1\n", $webpage);

    $trs = preg_split("/\n/i", $webpage);

    $resultList = array();
    foreach ($trs as $tr) {
      if (preg_match("/\"detName\"/i", $tr)) {
        array_push($resultList, $this->processLine($tr));
      }
    }
    # Try gzip
    if (sizeof($resultList) == 0) {
      exec("cat wget-test.html | gunzip > wget-test-gzip.html");
      $file = fopen("wget-test-gzip.html", "r") or die("can't open file");
      $webpage = fread($file, filesize("wget-test-gzip.html"));
      fclose($file);
      $webpage = preg_replace("/\n/i", "", $webpage);
      $webpage = preg_replace("/(\/tr>)/i", "$1\n", $webpage);

      $trs = preg_split("/\n/i", $webpage);

      foreach ($trs as $tr) {
        if (preg_match("/\"detName\"/i", $tr)) {
          array_push($resultList, $this->processLine($tr));
        }
      }
    }
    return $resultList;
  }
}


//$search = $_GET["search"];
//if ($search != "") {
