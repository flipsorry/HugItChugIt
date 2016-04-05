<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/v1/data/mysql/ImageDao.php';
$imageDao = new ImageDao();

# TODO read the get attributes
$search = urldecode($_GET["search"]);
# TODO check if we have in our DB
$images = $imageDao->getImages($search);

# TODO write to DB
echo json_encode(array('images' => $images));
?>
