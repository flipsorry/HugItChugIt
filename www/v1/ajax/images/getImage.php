<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/v1/data/mysql/ImageDao.php';
$imageDao = new ImageDao();

# TODO read the get attributes
$search = urldecode($_GET["search"]);
# TODO check if we have in our DB
$imageCache = $imageDao->getRequest($search);
if (! is_null($imageCache)) {
  echo json_encode(array('images' => array($imageCache), 'cacheHit' => true));
  return;
}

$getImage = "phantomjs getImage.js '$search'";
$grepPng = 'egrep -o "data:image/jpeg;base64[^\"]+';
#echo exec("$getImage");
#echo exec("$getImage | $grepPng", $result);

$output = shell_exec("$getImage");
$images = array();
foreach (explode("\n", $output) as $line) {
  #echo "LINE $line";
  preg_match('/data:image\/jpeg;base64[^\"]+/', $line, $matches);
  if ($matches) {
    #var_dump($matches);
    array_push($images, $matches[0]);
  }
}
# let's just cache the first result in our DB
$imageDao->putRequest($search, $images[0]);

# TODO write to DB
echo json_encode(array('images' => $images, 'cacheHit' => false));
?>
