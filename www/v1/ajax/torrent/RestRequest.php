<?php

class RestRequest {
  public function makeRequest($method, $url, $params) {

    $options = array(
      'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => $method,
        'content' => http_build_query($params),
      ),
    );
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    return $result;
  }
  
  private function buildQuery() {
  	
  }
}

?>
