<?php

class MetadataDao {
    public function getRequest($name) {
        $con = $this->getConnection();
        $value = '';
        try {
            $result = mysql_query("select * from metadata where name = '$name'");
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
        $result = '';
        try {
            $result = mysql_query("REPLACE INTO metadata VALUES ('$name', '$value');");
        } finally {
            mysql_close($con);
        }
        return $result;
    }
    
    public function putLog($action, $message) {
        $con = $this->getConnection();
        $result = '';
        $now = microtime();
        try {
            $result = mysql_query("INSERT INTO actionlog VALUES ('$action', '$message', now(), '$now');");
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
            mysql_select_db("CardGame", $con);
            return $con;
        }
    }
}

?>
