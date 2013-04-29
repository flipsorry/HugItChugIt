<?php
  require_once 'wget-library.php';
  $torrentService = new HttpRequest();
  $search = $_GET["search"];
  if ($search != "") {
    $torrents = $torrentService->getTorrentList($search);
    //foreach ($torrents as $torrent) {
    //  echo $torrent['name'];
    //}
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Torrenting at its best</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
      table {
        margin-top:20px;
      }
    </style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
  </head>
  <body>
    <?php include 'nav/navigation.php' ?>
    <div class="container">
      <p>A clean and energy efficient way to torrent</p>
      
      <form>
      <div>
        <input type="text" name="search" placeholder="Game of Thrones..." value="<?= $search ?>">
      </div>
      <div>
        <button class="btn">Search</button>
      </div>
      </form>
<?php
   if ($torrents) {
      echo "<table class='table table-striped'>";
      echo "  <thead><th>Name</th><th>Seeds</th></thead>";
      echo "  <tbody>";
      foreach ($torrents as $torrent) {
        echo "<tr>";
        echo "  <td>";
        echo "    <button class='btn btn-link download' data-magnet='" . $torrent['magnet'] . "'>";
        echo $torrent['name'];
        echo "    </button>";
        echo "  </td>";
        echo "  <td>";
        echo "    <span class='seeds'>";
        echo $torrent['seeds'];
        echo "    </span>";
        echo "  </td>";
        echo "</tr>";
      }
      echo "  </tbody>";
      echo "</table>";
   }
?>
    </div>
    <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript">

(function() {
  $(".download").click(function() {
    //addTorrent($(this).html(), $(this).data("magnet"));
   $(this).html('<img style="-webkit-user-select: none" src="http://ecx.images-amazon.com/images/G/01/x-locale/common/loading/loading-1x">');
   
   var thisDom = $(this);
   var magnet = thisDom.data("magnet");
   var parentDom = thisDom.parent().parent();
   parentDom.find('.seeds').slideUp();

   $.ajax({
     url: "../addTorrent.php?magnet=" + magnet, 
     complete: function() {
        thisDom.slideUp(1200, function() {
          parentDom.hide();
        });
     }
   });
    
  });
})();
    </script>
  </body>
</html>
