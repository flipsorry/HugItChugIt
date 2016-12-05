<!DOCTYPE html>
<html>
  <head>
    <title>Torrenting at its best</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="css/glyphs.css" rel="stylesheet">
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
      table {
        margin-top:20px;
      }
      .glyphicon-refresh-animate {
          -animation: spin .7s infinite linear;
          -ms-animation: spin .7s infinite linear;
          -webkit-animation: spinw .7s infinite linear;
          -moz-animation: spinm .7s infinite linear;
      }

      @keyframes spin {
          from { transform: scale(1) rotate(0deg);}
          to { transform: scale(1) rotate(360deg);}
      }
        
      @-webkit-keyframes spinw {
          from { -webkit-transform: rotate(0deg);}
          to { -webkit-transform: rotate(360deg);}
      }

      @-moz-keyframes spinm {
          from { -moz-transform: rotate(0deg);}
          to { -moz-transform: rotate(360deg);}
      }
      #chromecastButton {
        width: 45px;
      }
      #loadingSpinner {
        color: #fff;
        padding-left: 10px;
      }
    </style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </head>
  <body id="body">
<div id="entire-container">  
	<div class="navbar navbar-inverse navbar-fixed-top">
	  <div class="navbar-inner">
	    <div class="container">
        <button type="button" id="chromecastButton" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
          <img id="chromecastImage" src="img/chromecast/ic_cast_connected_white_24dp.png" />
        </button>
	      <a class="brand" href="#">HugItChugIt</a>
	      <div class="nav-collapse collapse">
	        <ul class="nav">
            <li><div id="loadingSpinner"><span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span></li>
	          <li class="active"><a href="torrents.php">Home</a></li>
	          <li><a href="/v1/torrents-downloading.php">Downloading</a></li>
	          <li><a href="/Dos/Torrents/?C=M;O=D">Finished</a></li>
	        </ul>
	      </div><!--/.nav-collapse -->
	    </div>
	  </div>
	</div>
