<?php 
    require_once $_SERVER['DOCUMENT_ROOT'] . '/v1/data/mysql/MetadataDao.php';
    $metadataDao = new MetadataDao();
    $action = $_GET["action"];
    $message = $_GET["message"];
    
    echo $metadataDao->putLog($action, $message);
?>