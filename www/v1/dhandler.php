<?php
  function dispatchView() {
    $viewId = $_GET["viewId"];
    include $viewId . '.php';
  }

  dispatchView();
?>
