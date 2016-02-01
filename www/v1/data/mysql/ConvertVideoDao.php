<?php

class ConvertVideoDao {
   public function putRequest($title, $inputFile, $outputFile, $logFile, $type, $additionalArgs) {
        $con = $this->getConnection();
        $result = NULL;
        try {
            $result = mysql_query("REPLACE INTO ConvertVideo VALUES ('$title', '$inputFile', '$outputFile', '$logFile', '$type', '$additionalArgs', 'ENQUEUE');");
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
