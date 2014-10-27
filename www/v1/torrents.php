<?php
  require_once 'data/torrent-search/wget-library.php';
  $torrentService = new HttpRequest();
  $search = $_GET["search"];
  if ($search != "") {
    $torrents = $torrentService->getTorrentList($search);
  }
?>
    <?php include 'nav/navigation.php' ?>
    <div class="container">
      <p>A clean and energy efficient way to torrent</p>
      
      <form>
      <div>
        <input type="text" name="search" placeholder="Game of Thrones..." value="<?= $search ?>" x-webkit-speech>
      </div>
      <div>
        <button class="btn">Search</button>
      </div>
      </form>
<?php
   $periods = array(",", ".", "-");
   if ($torrents) {
      echo "<table class='table table-striped'>";
      echo "  <thead><th>Name</th><th>Seeds</th></thead>";
      echo "  <tbody>";
      foreach ($torrents as $torrent) {
        echo "<tr>";
        echo "  <td>";
        echo "    <button class='btn btn-link download' data-magnet='" . $torrent['magnet'] . "'>";
        echo str_replace($periods, " ", $torrent['name']);
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
     url: "ajax/torrent/addTorrent.php?magnet=" + magnet, 
     complete: function() {
        thisDom.slideUp(1200, function() {
          parentDom.hide();
        });
     }
   });
    
  });
})();
    </script>
    
<?php include 'nav/navigation-end.php' ?>
