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
    echo exec("wget -O wget-test.html http://thepiratebay.se/search/" . urlencode($search) . "/0/7/0");
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
    return $resultList;
  }
}


//$search = $_GET["search"];
//if ($search != "") {
