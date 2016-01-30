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

  public function makeRestRequest($method, $url, $params, $headers) {
    $request = new HttpRequest($url, HttpRequest::METH_GET);
    $headers = empty($headers) ? array() : $headers;
    $request->addHeaders($headers);
    try {
      $request->send();
    } catch (HttpException $ex) {
      echo "ERROR";
      var_dump($ex);
      return $ex;
    }
    return $request; 
  }

  public function makeAuthRequest($method, $user, $password, $url, $params, $headers) {
    $headers = empty($headers) ? array() : $headers;
    $headers['Authorization'] = 'Basic ' . base64_encode("$user:$password");
    return $this->makeRestRequest($method, $url, $params, $headers);
  }
  
  private function buildQuery() {
  	
  }
}

?>
