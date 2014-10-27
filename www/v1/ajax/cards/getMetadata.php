<?php 
    require_once $_SERVER['DOCUMENT_ROOT'] . '/v1/data/mysql/MetadataDao.php';
    $metadataDao = new MetadataDao();
    $names = $_GET["names"];
    $namesSplit = explode(',', $names);
    $returnArray = array();
    foreach ($namesSplit as $name) {
        $value = $metadataDao->getRequest($name);
        $returnArray[$name] = $value;
    }
    
    echo json_encode($returnArray);
?>