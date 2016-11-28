<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/v1/data/torrent-search/wget-library.php';
  $torrentService = new TorrentHttpRequest();
  $data = json_decode(file_get_contents('php://input'));
  $search = $_POST["search"] ? $_POST["search"] : $_GET["search"];
  if($search == "") {
    $search = $data->{'search'};
  }
  $torrents = [];
  if ($search != "") {
    $torrents = $torrentService->getTorrentList($search);
  }
  echo json_encode(array('torrents' => $torrents));
?>
