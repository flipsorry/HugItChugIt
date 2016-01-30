<?php

class TorrentHttpRequest {
  public function getTorrentList($search) {
    return $this->callPirateAndProcess($search);
  }

  // Strips out the important information in the line
  private function processLinePirate($line) {
    preg_match("/a href=\"\/torrent.*>\<span>(.*)\<\/span>\<\/a>/i", $line, $nameMatch);
    $name = $nameMatch[1];

    # magnet:?xt=urn:btih:6e8ecb71750f9c4
    # preg_match("/a href=\"(magnet[^ ]*)\"/i", $line, $magnetMatch);
    preg_match("/a href='(magnet\S+)'/i", $line, $magnetMatch);
    # echo htmlentities($line) . "ARG<br />";
    #print_r($magnetMatch);
    $magnet = urlencode($magnetMatch[1]);

    preg_match("/\<td class=\"seeders-row sy\">([0-9]*)\<\/td>/i", $line, $seedMatch);
    $seeds = $seedMatch[1];
   
    return array('name' => $name, 'magnet' => $magnet, 'seeds' => $seeds);
  }

  // Strips out the important information in the line
  // works for kickass
  private function processLine($line) {
    preg_match("/class=\"cellMainLink\">(.*)\<\/a>.*<\/a>.*<\/a>/i", $line, $nameMatch);
    $name = $nameMatch[1];

    # magnet:?xt=urn:btih:6e8ecb71750f9c4
    # preg_match("/a href=\"(magnet[^ ]*)\"/i", $line, $magnetMatch);
    preg_match("/href=\"(magnet\S+)\"/i", $line, $magnetMatch);
    # echo htmlentities($line) . "ARG<br />";
    #print_r($magnetMatch);
    $magnet = urlencode($magnetMatch[1]);

    preg_match("/\<td class=\"green center\">([0-9]*)\<\/td>/i", $line, $seedMatch);
    $seeds = $seedMatch[1];

    return array('name' => $name, 'magnet' => $magnet, 'seeds' => $seeds);
  }

  private function callPirateAndProcess($search) {
    echo exec("rm wget-test.html");
    fclose($file);

    # echo exec("wget -q -O- https://thepiratebay.se/search/" . urlencode($search) . "/0/7/0 | gunzip > wget-test.html");
    # echo exec("wget -q -O wget-test.html http://oldpiratebay.org/search/" . urlencode($search) . "/0/7/0");
    # echo exec("wget -q -O wget-test.html http://oldpiratebay.org/search.php?Torrent_sort=seeders.desc&q=" . urlencode($search));
    #echo exec("curl \"https://oldpiratebay.org/search.php?Torrent_sort=seeders.desc&q=" . urlencode($search) . "\" -H \"accept-encoding: gzip, deflate, sdch\" -H \"accept-language: en-US,en;q=0.8\" -H \"user-agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.95 Safari/537.36\" -H \"accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8\" -H \"cache-control: max-age=0\" --compressed > wget-test.html");
    $webpage = shell_exec("curl \"https://kat.cr/usearch/" . urlencode($search) . "/?field=seeders&sorder=desc\" -H \"accept-language: en-US,en;q=0.8\" -H \"user-agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.111 Safari/537.36\" -H \"Cookie: country_code=US\" -H \"accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8\" -H \"cache-control: max-age=0\" --compressed");
    $webpage = preg_replace("/\n/i", "", $webpage);
    $webpage = preg_replace("/(\/tr>)/i", "$1\n", $webpage);

    $trs = preg_split("/\n/i", $webpage);

    $resultList = array();
    foreach ($trs as $tr) {
      if (preg_match("/MAGNET LINK/i", $tr)) {
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
