<?php

class ImageDao {

    public function getImages($search) {
        $imageCache = $this->getRequest($search);
        if (! is_null($imageCache)) {
          return array($imageCache);
        }
        $getImage = "phantomjs /home/flipsorry/www/v1/data/mysql/getImage.js '$search'";
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
        $this->putRequest($search, $images[0]);
        return $images;
    }

    public function getRequest($name) {
        $con = $this->getConnection();
        $value = NULL;
        try {
            $result = mysql_query("select * from images where name = '$name'");
            while($row = mysql_fetch_array($result)) {
                $name = $row['name'];
                $value = $row['value'];
            }
        } finally {
            mysql_close($con);
        }
        return $value;
    }
    
   public function putRequest($name, $value) {
        $con = $this->getConnection();
        $result = NULL;
        try {
            $result = mysql_query("REPLACE INTO images VALUES ('$name', '$value');");
        } finally {
            mysql_close($con);
        }
        return $result;
    }
    
    public function putLog($header, $message) {
        $con = $this->getConnection();
        $result = '';
        $now = microtime();
        try {
            $result = mysql_query("INSERT INTO logs VALUES ('$header', '$message', now(), '$now');");
        } finally {
            mysql_close($con);
        }
        return $result;
    }
    
    private function getConnection() {
        header('Content-Type: application/json');
        $con = mysql_connect("localhost","root","liemdinh");
        if (!$con){
            die('Could not connect: ' . mysql_error());
        } else {
            mysql_select_db("Torrents", $con);
            return $con;
        }
    }
}

?>
