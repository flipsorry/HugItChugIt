<?php
?>
    <?php include 'nav/navigation.php' ?>
    
<style>
	progress[value] {
	  /* Reset the default appearance */
	  -webkit-appearance: none;
	   appearance: none;
	
	  width: 150px;
	  height: 20px;
	}
	progress[value]::-webkit-progress-bar {
	  background-color: #eee;
	  border-radius: 2px;
	  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.25) inset;
	}
	progress[value]::-webkit-progress-value {
	  background-image:
		   -webkit-linear-gradient(-45deg, 
		                           transparent 33%, rgba(0, 0, 0, .1) 33%, 
		                           rgba(0,0, 0, .1) 66%, transparent 66%),
		   -webkit-linear-gradient(top, 
		                           rgba(255, 255, 255, .25), 
		                           rgba(0, 0, 0, .25)),
		   -webkit-linear-gradient(left, #09c, #f44);
	
	    border-radius: 2px; 
	    background-size: 35px 20px, 100% 100%, 100% 100%;
	    -webkit-animation: animate-stripes 5s linear infinite;
        animation: animate-stripes 5s linear infinite;
	}
	@-webkit-keyframes animate-stripes {
	   100% { background-position: -100px 0px; }
	}
	
	@keyframes animate-stripes {
	   100% { background-position: -100px 0px; }
	}
	progress[value]::-webkit-progress-value::before {
	  content: '80%';
	  position: absolute;
	  right: 0;
	  top: -125%;
	}
	progress[value]::-webkit-progress-value::after {
	  content: '';
	  width: 6px;
	  height: 6px;
	  position: absolute;
	  border-radius: 100%;
	  right: 7px;
	  top: 7px;
	  background-color: white;
	}
</style>
    <div class="container">
      <h3>Downloading</h3>
      <div id="loader"><img style="-webkit-user-select: none" src="http://ecx.images-amazon.com/images/G/01/x-locale/common/loading/loading-1x"></div>
      
      <table class='table table-striped'>
      	<thead>
      		<th>Name</th>
      		<th>Speed</th>
      		<th>Progress</th>
      		<th>State</th>
      	</thead>
      	<tbody id="torrentList">
      		
      	</tbody>
      </table>
    </div>
    <script type="text/javascript">

(function() {

	var insertTorrentToTable = function(torrentData) {
		var hash = torrentData["hash"];
		var torrentDom = $("#" + hash);
		if (torrentDom.length == 0) {
			var torrentHtml = "<td>" + torrentData["name"] + "</td>";
			torrentHtml += "<td>" + torrentData["dlspeed"] + "</td>";
			torrentHtml += "<td>" + createProgressBar(torrentData["progress"]) + "</td>";
			torrentHtml += "<td>" + torrentData["state"] + "</td>";
			var torrentContainer = "<tr id='" + hash + "'>" + torrentHtml + "</tr>"; 
			$("#torrentList").append(torrentContainer);
		}
	};

	var createProgressBar = function(progress) {
		return '<progress value="' + progress + '" max="1.0"></progress>';
	};
	
   $.ajax({
     url: "ajax/torrent/torrentRequest.php",
     data: {
     	method: "GET",
     	url: "/json/torrents"
     },
     dataType: "json"
   })
   .done(function(result) {
	   	$("#loader").hide();
	   	console.log(result); 
	   	if (result.length > 0) {
		   	for (var i = 0; i < result.length; i++) {
			   	var torrentData = result[i];
			   	insertTorrentToTable(torrentData);
		   	}
	   	}
   });
    
})();
    </script>
    
<?php include 'nav/navigation-end.php' ?>
