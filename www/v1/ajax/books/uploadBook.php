<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/v1/data/mysql/ImageDao.php';
  $imageDao = new ImageDao();

  // Converts ebooks to mobi if not already and then sends to my email
  // probably can put an end email
  $bookLocation = $_GET["bookLocation"];
  $endLocationName = $_GET["endLocation"];
  $bookName = $_GET["bookName"];
  $rand = rand(0, 10000);
  $endLocation = "/home/flipsorry/Dos/Books/$endLocationName-" . $rand . ".mobi";
  $coverLocationEncoded = "/home/flipsorry/Dos/Books/$endLocationName-" . $rand . "-encoded.txt";
  $coverLocation = "/home/flipsorry/Dos/Books/$endLocationName-" . $rand . ".jpeg";
  $type = $_GET["type"];
  echo $bookLocation;
  echo "\n\n";

  $images = $imageDao->getImages($bookName);
  # data:image/jpeg;base64,
  $encoded = str_replace("data:image/jpeg;base64,", "", $images[0]);
  echo "\n\n";
  #echo $encoded;
  #echo "\n\n";
  $file = fopen("$coverLocationEncoded", "w");
  echo fwrite($file, $encoded);
  fclose($file);
  $decoded = exec("base64 --decode $coverLocationEncoded > $coverLocation");
  

  if (strcmp(".mobi", $type) !== 0) {
    $convertOutput = array();
    // we need to translate to mobi first
    echo exec("pwd");
    echo exec("ebook-convert \"$bookLocation\" \"$endLocation\" --cover $coverLocation", $convertOutput);
    var_dump($convertOutput);
  } else {
    echo exec("cp \"$bookLocation\" \"$endLocation\"");
  }
  $emailOutput = array();
  $email = "liemhdinh@kindle.com";
  $command = "echo \"Send To Kindle\" | mail -A \"$endLocation\" -s \"Send to Kindle\" $email";
  exec($command, $emailOutput);
  echo "<br /><br />";
  echo $command;
  var_dump($emailOutput);
  # http://drakestears.com/v1/ajax/books/uploadBook.php?bookLocation=/home/flipsorry/Dos/Torrents/TippingPoint/Gladwell_Malcolm-Tipping_Point_The.epub&endLocation=TippingPoint&bookName=The%20Tipping%20Point%20Malcolm%20Gladwell%20-%20Audiobook
?>
