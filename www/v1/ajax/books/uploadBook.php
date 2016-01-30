<?php
  // Converts ebooks to mobi if not already and then sends to my email
  // probably can put an end email
  $bookLocation = $_GET["bookLocation"];
  $endLocation = $_GET["endLocation"];
  $endLocation = "/home/flipsorry/Dos/Torrents/book" . rand(0, 10000) . ".mobi";
  $type = $_GET["type"];
  echo $bookLocation;
  echo "<br /><br />";
  if (strcmp(".mobi", $type) !== 0) {
    $convertOutput = array();
    // we need to translate to mobi first
    echo exec("pwd");
    echo exec("ebook-convert \"$bookLocation\" \"$endLocation\"", $convertOutput);
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
?>
