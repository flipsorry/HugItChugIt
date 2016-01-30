<?php
  require_once 'RestRequest.php';
  $rest = new RestRequest();
  $method = $_GET["method"];
  $url = 'http://localhost:8088' . $_GET["url"];
  
  $params = array();
  
  foreach ($_GET as $key => $value) { 
  	if (strcmp($key, 'method') !== 0 && strcmp($key, 'url') !== 0) {
  		$params[$key] = htmlspecialchars($value);
  	}
  }
  
  $results = $rest->makeRequest($method, $url, $params);
  $decoded = json_decode($results);
  $booksFound = array();

  #exec("find /home/flipsorry/Dos/Torrents | egrep -i \"\.(epub|mobi)\"", $findResults);
  #var_dump($findResults);
  foreach($decoded as $torrentIndex => $torrent) {
    $name = $torrent->{'name'};
    $hash = $torrent->{'hash'};
    $findResults = array();
    exec("find /home/flipsorry/Dos/Torrents | grep \"$name\"", $findResults);
    $bookList = array();
    foreach($findResults as $bookIndex => $bookLocation) {
      #echo $bookLocation;
      preg_match("/\.(epub|mobi)/i", $bookLocation, $bookMatch);
      if ($bookMatch) {
        $book = array();
        $book['location'] = $bookLocation;
        $book['type'] = strtolower($bookMatch[0]);
        array_push($bookList, $book);
      }
    }
    if (count($bookList) > 0) {
      $booksFound[$hash] = $bookList;
    }
  }
  #$decoded->{'booksFound'} = $booksFound;
  $combinedResults = array();
  $combinedResults['booksFound'] = $booksFound;
  $combinedResults['torrentsDownloading'] = $decoded; 

  echo json_encode($combinedResults);
?>
