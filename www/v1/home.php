<?php
?>
    <?php include 'nav/navigation-chromecast.php' ?>
    
<style>

  body#body {
    padding-left: 0px;
    padding-right: 0px;
  }

  div.navbar-fixed-top {
    margin-left: 0px;
    margin-right: 0px;
    margin-bottom: 0px;
  }

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

  div#title {
    background: #fff;
    color: #666;
    padding-left: 20px;
    border-bottom: 3px solid #0072bc;
    margin-bottom:5px;
  }

  div.torrentsContainer {
    background: #eee;
  }

  div.torrentBox {
    background: #fff;
    border-top: 1px solid #e3e3e3;
    border-bottom: 2px solid #ccc;
    margin: 0 8px 10px 8px;
    padding: 20px;
    clear: both;
    min-height: 100px;
    -webkit-box-shadow: 5px 5px 5px #888;
    border-radius: 5px;
  }

  div.image {
    float: left;
    min-width: 100px;
  }
  div.image img {
    max-height: 100px;
  }
</style>
    <div class="torrentsContainer">
      <div id="title"><h4>Downloading</h4></div>
      <div id="loader"><img style="-webkit-user-select: none" src="http://ecx.images-amazon.com/images/G/01/x-locale/common/loading/loading-1x"></div>
      <div id="play"><button id='playButton' class='btn btn-link download'>Play</button></div>
      <div id="torrentList">
      </div>

    </div>
    <!--<script type="text/javascript" src="https://www.gstatic.com/cv/js/sender/v1/cast_sender.js" ></script>
    -->
    <script type="text/javascript">

(function() {

	var insertTorrentToTable = function(torrentData) {
		var hash = torrentData[0];
    var speed = (torrentData[9] / 1000000.0);
    if (speed == 0) speed = "";
    var progress = createProgressBar(torrentData[4] / 1000.0);
    var state = torrentData[21];

		var torrentDom = $("#" + hash);
    if (torrentDom.length == 0) {
      // title
      var title =  torrentData[2];
      title = title
            .replace(/\./g, " ")
            .replace(/_/g, " ")
            .replace(/\[[a-zA-Z0-9\.\- ]+\]/g, "")
            .replace(/\[[^\]+]\]/gi, "")
            .replace(/\([0-9]+\).*/gi, "")
            .replace(/(19|20)[0-9]+.*/, "")
            .replace(/(x264|720|1080|webrip).*/gi, "");
      var torrentHtml = "<div class='image'></div>";
      torrentHtml += "<div class='rightColumn'>";
      torrentHtml += "  <div>" + title + "</div>";
      //torrentHtml += "<div>" + torrentData[2] + "</div>";
      torrentHtml += "  <span class='progress'>" + progress + "</span>";
      // speed
      torrentHtml += "  <span class='speed'>" + speed + "</span>";
      // state
      // torrentHtml += "  <span class='state'>" + state + "</span>";
      torrentHtml += "</div>";
      var torrentContainer = "<div class='torrentBox' id='" + hash + "'>" + torrentHtml + "</div>"; 
      $("#torrentList").append(torrentContainer);

      // go get the image
      $.ajax({
        url: "ajax/images/getImage.php",
        data: {
          search: title
        },
        dataType: "json"
      })
      .done(function(result) {
        //console.log(result.images[0]);
        var torrentDom = $("#" + hash);
        //torrentDom.find(".image").html("hello");
        torrentDom.find(".image").html("<img src='" + result.images[0] + "' />");
        //console.log(torrentDom.find(".image"));
      });

    } else {
      torrentDom.find('.speed').html(speed);
      torrentDom.find('.progress').html(progress);
      // torrentDom.find('.state').html(state);
    }
	};

	var createProgressBar = function(progress) {
		return '<progress value="' + progress + '" max="1.0"></progress>';
	};
	
   var reload = function() {
   $.ajax({
     url: "ajax/torrent/utorr/listTorrents.php",
     data: {
     },
     dataType: "json"
   })
   .done(function(result) {
	   	$("#loader").hide();
      var torrents = result.torrents;
	   	console.log(torrents); 
	   	if (torrents.length > 0) {
		   	for (var i = 0; i < torrents.length; i++) {
			   	var torrentData = torrents[i];
          //console.log(torrentData);
			   	insertTorrentToTable(torrentData);
		   	}
	   	}
   });

   setTimeout(function() {
     reload();
   }, 5000);
   };

   $.ajax({
     url: "ajax/torrent/utorr/getToken.php",
     data: {
     }
   })
   .done(function(tokenResult) {
     reload();
   });

   //if (ChromecastInfo) {
   // console.log(ChromecastInfo);
   // console.log(ChromecastInfo.getAvailableChromecasts());
   //}

   if (webkit) {
     webkit.messageHandlers.callbackHandler.postMessage("Hello from Js: " + Date.now());
   }
   window.setChromecasts = function(chromecastList) {
     console.log(chromecastList);
     return "hello world " + chromecastList;
   }

   function searchChromecasts() {
      setTimeout(function() {
           webkit.messageHandlers.callbackHandler.postMessage("timeout call: " + Date.now());
           searchChromecasts();
      }, 5000)
   }

   //searchChromecasts();

   var startVideo = function() {
     webkit.messageHandlers.callbackHandler.postMessage("timeout call: " + Date.now());
   }

   $("#playButton").click(function() {
     startVideo();
   });

   window.webkitLoaded = function() {
     console.log("webkitLoaded");
   };

})();
    </script>
    
<?php include 'nav/navigation-end.php' ?>
