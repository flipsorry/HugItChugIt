<?php
	$magnet = htmlspecialchars($_GET["magnet"]);
  $url = "http://localhost:8088/command/download";
  $data = array('urls' => $magnet);

  $options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data),
    ),
  );
  $context  = stream_context_create($options);
  $result = file_get_contents($url, false, $context);
?>
