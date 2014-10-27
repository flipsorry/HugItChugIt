<?php 
    require_once $_SERVER['DOCUMENT_ROOT'] . '/v1/data/mysql/MetadataDao.php';
    $metadataDao = new MetadataDao();
    $name = $_GET["name"];
    $value = $_GET["value"];
    
    echo $metadataDao->putRequest($name, $value);
?>