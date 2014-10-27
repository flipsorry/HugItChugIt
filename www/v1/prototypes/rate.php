<?php
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Amazon Ratings</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    <link rel="apple-touch-icon" href="http://www.playmys.org/images/amazon%20small%20logo.jpg" />
    <style>
      body {
        background-color: #dee0e3;
        margin-top: 50px;
      }
      .navbar .brand {
        color: #ffffff;
      }
      div.navbar-fixed-top {
          position: fixed;
      }
      div.navbar-fixed-top {
        margin-right: 0;
        margin-left: 0;
      }
      .candidateContainer {
        padding: 20px;
        margin: 20px 0 20px 0;
        background-color: #ffffff;
        -webkit-box-shadow: 5px 5px 5px #888;
        border-radius: 5px;
      }
      .prImage {
        height: 150px;
        width: 105px;
      }
      .prColumn {
        width: 105px;
      }
      .prDescrColumn {
        padding-left: 10px; 
        vertical-align: top;
      }

      .content-btn {
        width: 100px;
        margin-bottom: 10px;
      }

      .stars {
        background: url('http://g-ec2.images-amazon.com/images/G/01/x-locale/common/customer-reviews/ryp-sprited-medium-and-small-hdpi-stars._V380602474_.png') no-repeat;
      }

      .med-star { 
        width: 43px;
        height: 41px;
        display: moz-inline-block;
        display: inline-block;
        margin: 0;
        padding: 0;
        position: relative;
        vertical-align: middle; 
      }

      .unselect-star {
        background-position: 0px 0px;
      }

      .select-star { 
        background-position: -45px 0px;
      }

      .starContainer {
        margin-top: 10px;
      }
    </style>
  </head>
  <body>
<div class="navbar navbar-inverse navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container">
      <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="brand" href="#">Amazon Ratings</a>
      <div class="nav-collapse collapse">
        <ul class="nav">
          <li class="active"><a href="rate.php">Best Seller</a></li>
          <li><a href="rate.php">Comedy</a></li>
        </ul>
      </div><!--/.nav-collapse -->
    </div>
  </div>
</div> 
    <div class="contentContainer">
      <div class="container">
        <div class="candidateContainer">
          <h4>What Should I Watch Next</h4>
          Here are some movies that we think you have watch or would be interested in watching. Rate these movies to get better recommendations. 
        </div>
        <div class="candidateContainer">
            <table>
              <tr>
                <td class="prColumn">
                  <img src="http://ecx.images-amazon.com/images/I/51E45u9uGRL._SX500_.jpg" class="prImage" />
                </td>
                <td class="prDescrColumn">
                  <div> 
                    <strong>Cloud Atlas</strong>
                  </div>
                  <div>
                    A single story that unfolds in multiple timelines...
                  </div>
                  <div>
                    <button class="btn content-btn">Watch Now</button>
                  </div>
                  <div>
                    <button class="btn content-btn">Wishlist</button>
                  </div>
                </td>
              </tr>
            </table>
            <div class="starContainer">
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
            </div>
        </div>

        <div class="candidateContainer">
            <table>
              <tr>
                <td class="prColumn">
                  <img src="http://ecx.images-amazon.com/images/I/51cN3kGbQ%2BL._SX500_.jpg" class="prImage" />
                </td>
                <td class="prDescrColumn">
                  <div>
                    <strong>The Dark Knight Rises</strong>
                  </div>
                  <div>
                    I am batman...
                  </div>
                  <div>
                    <button class="btn content-btn">Watch Now</button>
                  </div>
                  <div>
                    <button class="btn content-btn">Wishlist</button>
                  </div>
                </td>
              </tr>
            </table>
            <div class="starContainer">
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
            </div>
        </div>
    
        <div class="candidateContainer">
            <table>
              <tr>
                <td class="prColumn">
                  <img src="http://ecx.images-amazon.com/images/I/51soDF9FBIL._SX500_.jpg" class="prImage" />
                </td>
                <td class="prDescrColumn">
                  <div>
                    <strong>Argo</strong>
                  </div>
                  <div>
                    Oh ben affleck...
                  </div>
                  <div>
                    <button class="btn content-btn">Watch Now</button>
                  </div>
                  <div>
                    <button class="btn content-btn">Wishlist</button>
                  </div>
                </td>
              </tr>
            </table>
            <div class="starContainer">
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
            </div>
        </div>

        <div class="candidateContainer">
            <table>
              <tr>
                <td class="prColumn">
                  <img src="http://ecx.images-amazon.com/images/I/51zP7nv%2BMVL._SX500_.jpg" class="prImage" />
                </td>
                <td class="prDescrColumn">
                  <div>
                    <strong>Silver Linings</strong>
                  </div>
                  <div>
                    Catnip in a real world...
                  </div>
                  <div>
                    <button class="btn content-btn">Watch Now</button>
                  </div>
                  <div>
                    <button class="btn content-btn">Wishlist</button>
                  </div>
                </td>
              </tr>
            </table>
            <div class="starContainer">
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
            </div>
        </div>

        <div class="candidateContainer">
            <table>
              <tr>
                <td class="prColumn">
                  <img src="http://ecx.images-amazon.com/images/I/51MmmF4y9jL._SX500_.jpg" class="prImage" />
                </td>
                <td class="prDescrColumn">
                  <div>
                    <strong>Gangster Squad</strong>
                  </div>
                  <div>
                    We want more Ryan Gosling!
                  </div>
                  <div>
                    <button class="btn content-btn">Watch Now</button>
                  </div>
                  <div>
                    <button class="btn content-btn">Wishlist</button>
                  </div>
                </td>
              </tr>
            </table>
            <div class="starContainer">
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
            </div>
        </div>

        <div class="candidateContainer">
            <table>
              <tr>
                <td class="prColumn">
                  <img src="http://ecx.images-amazon.com/images/I/51E45u9uGRL._SX500_.jpg" class="prImage" />
                </td>
                <td class="prDescrColumn">
                  <div> 
                    <strong>Cloud Atlas</strong>
                  </div>
                  <div>
                    A single story that unfolds in multiple timelines...
                  </div>
                  <div>
                    <button class="btn content-btn">Watch Now</button>
                  </div>
                  <div>
                    <button class="btn content-btn">Wishlist</button>
                  </div>
                </td>
              </tr>
            </table>
            <div class="starContainer">
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
            </div>
        </div>

        <div class="candidateContainer">
            <table>
              <tr>
                <td class="prColumn">
                  <img src="http://ecx.images-amazon.com/images/I/51cN3kGbQ%2BL._SX500_.jpg" class="prImage" />
                </td>
                <td class="prDescrColumn">
                  <div>
                    <strong>The Dark Knight Rises</strong>
                  </div>
                  <div>
                    I am batman...
                  </div>
                  <div>
                    <button class="btn content-btn">Watch Now</button>
                  </div>
                  <div>
                    <button class="btn content-btn">Wishlist</button>
                  </div>
                </td>
              </tr>
            </table>
            <div class="starContainer">
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
            </div>
        </div>
    
        <div class="candidateContainer">
            <table>
              <tr>
                <td class="prColumn">
                  <img src="http://ecx.images-amazon.com/images/I/51soDF9FBIL._SX500_.jpg" class="prImage" />
                </td>
                <td class="prDescrColumn">
                  <div>
                    <strong>Argo</strong>
                  </div>
                  <div>
                    Oh ben affleck...
                  </div>
                  <div>
                    <button class="btn content-btn">Watch Now</button>
                  </div>
                  <div>
                    <button class="btn content-btn">Wishlist</button>
                  </div>
                </td>
              </tr>
            </table>
            <div class="starContainer">
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
            </div>
        </div>

        <div class="candidateContainer">
            <table>
              <tr>
                <td class="prColumn">
                  <img src="http://ecx.images-amazon.com/images/I/51zP7nv%2BMVL._SX500_.jpg" class="prImage" />
                </td>
                <td class="prDescrColumn">
                  <div>
                    <strong>Silver Linings</strong>
                  </div>
                  <div>
                    Catnip in a real world...
                  </div>
                  <div>
                    <button class="btn content-btn">Watch Now</button>
                  </div>
                  <div>
                    <button class="btn content-btn">Wishlist</button>
                  </div>
                </td>
              </tr>
            </table>
            <div class="starContainer">
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
            </div>
        </div>

        <div class="candidateContainer">
            <table>
              <tr>
                <td class="prColumn">
                  <img src="http://ecx.images-amazon.com/images/I/51MmmF4y9jL._SX500_.jpg" class="prImage" />
                </td>
                <td class="prDescrColumn">
                  <div>
                    <strong>Gangster Squad</strong>
                  </div>
                  <div>
                    We want more Ryan Gosling!
                  </div>
                  <div>
                    <button class="btn content-btn">Watch Now</button>
                  </div>
                  <div>
                    <button class="btn content-btn">Wishlist</button>
                  </div>
                </td>
              </tr>
            </table>
            <div class="starContainer">
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
            </div>
        </div>
        <div class="candidateContainer">
            <table>
              <tr>
                <td class="prColumn">
                  <img src="http://ecx.images-amazon.com/images/I/51E45u9uGRL._SX500_.jpg" class="prImage" />
                </td>
                <td class="prDescrColumn">
                  <div> 
                    <strong>Cloud Atlas</strong>
                  </div>
                  <div>
                    A single story that unfolds in multiple timelines...
                  </div>
                  <div>
                    <button class="btn content-btn">Watch Now</button>
                  </div>
                  <div>
                    <button class="btn content-btn">Wishlist</button>
                  </div>
                </td>
              </tr>
            </table>
            <div class="starContainer">
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
            </div>
        </div>

        <div class="candidateContainer">
            <table>
              <tr>
                <td class="prColumn">
                  <img src="http://ecx.images-amazon.com/images/I/51cN3kGbQ%2BL._SX500_.jpg" class="prImage" />
                </td>
                <td class="prDescrColumn">
                  <div>
                    <strong>The Dark Knight Rises</strong>
                  </div>
                  <div>
                    I am batman...
                  </div>
                  <div>
                    <button class="btn content-btn">Watch Now</button>
                  </div>
                  <div>
                    <button class="btn content-btn">Wishlist</button>
                  </div>
                </td>
              </tr>
            </table>
            <div class="starContainer">
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
            </div>
        </div>
    
        <div class="candidateContainer">
            <table>
              <tr>
                <td class="prColumn">
                  <img src="http://ecx.images-amazon.com/images/I/51soDF9FBIL._SX500_.jpg" class="prImage" />
                </td>
                <td class="prDescrColumn">
                  <div>
                    <strong>Argo</strong>
                  </div>
                  <div>
                    Oh ben affleck...
                  </div>
                  <div>
                    <button class="btn content-btn">Watch Now</button>
                  </div>
                  <div>
                    <button class="btn content-btn">Wishlist</button>
                  </div>
                </td>
              </tr>
            </table>
            <div class="starContainer">
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
            </div>
        </div>

        <div class="candidateContainer">
            <table>
              <tr>
                <td class="prColumn">
                  <img src="http://ecx.images-amazon.com/images/I/51zP7nv%2BMVL._SX500_.jpg" class="prImage" />
                </td>
                <td class="prDescrColumn">
                  <div>
                    <strong>Silver Linings</strong>
                  </div>
                  <div>
                    Catnip in a real world...
                  </div>
                  <div>
                    <button class="btn content-btn">Watch Now</button>
                  </div>
                  <div>
                    <button class="btn content-btn">Wishlist</button>
                  </div>
                </td>
              </tr>
            </table>
            <div class="starContainer">
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
            </div>
        </div>

        <div class="candidateContainer">
            <table>
              <tr>
                <td class="prColumn">
                  <img src="http://ecx.images-amazon.com/images/I/51MmmF4y9jL._SX500_.jpg" class="prImage" />
                </td>
                <td class="prDescrColumn">
                  <div>
                    <strong>Gangster Squad</strong>
                  </div>
                  <div>
                    We want more Ryan Gosling!
                  </div>
                  <div>
                    <button class="btn content-btn">Watch Now</button>
                  </div>
                  <div>
                    <button class="btn content-btn">Wishlist</button>
                  </div>
                </td>
              </tr>
            </table>
            <div class="starContainer">
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
            </div>
        </div>
        
        <div class="candidateContainer">
            <table>
              <tr>
                <td class="prColumn">
                  <img src="http://ecx.images-amazon.com/images/I/51E45u9uGRL._SX500_.jpg" class="prImage" />
                </td>
                <td class="prDescrColumn">
                  <div> 
                    <strong>Cloud Atlas</strong>
                  </div>
                  <div>
                    A single story that unfolds in multiple timelines...
                  </div>
                  <div>
                    <button class="btn content-btn">Watch Now</button>
                  </div>
                  <div>
                    <button class="btn content-btn">Wishlist</button>
                  </div>
                </td>
              </tr>
            </table>
            <div class="starContainer">
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
            </div>
        </div>

        <div class="candidateContainer">
            <table>
              <tr>
                <td class="prColumn">
                  <img src="http://ecx.images-amazon.com/images/I/51cN3kGbQ%2BL._SX500_.jpg" class="prImage" />
                </td>
                <td class="prDescrColumn">
                  <div>
                    <strong>The Dark Knight Rises</strong>
                  </div>
                  <div>
                    I am batman...
                  </div>
                  <div>
                    <button class="btn content-btn">Watch Now</button>
                  </div>
                  <div>
                    <button class="btn content-btn">Wishlist</button>
                  </div>
                </td>
              </tr>
            </table>
            <div class="starContainer">
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
            </div>
        </div>
    
        <div class="candidateContainer">
            <table>
              <tr>
                <td class="prColumn">
                  <img src="http://ecx.images-amazon.com/images/I/51soDF9FBIL._SX500_.jpg" class="prImage" />
                </td>
                <td class="prDescrColumn">
                  <div>
                    <strong>Argo</strong>
                  </div>
                  <div>
                    Oh ben affleck...
                  </div>
                  <div>
                    <button class="btn content-btn">Watch Now</button>
                  </div>
                  <div>
                    <button class="btn content-btn">Wishlist</button>
                  </div>
                </td>
              </tr>
            </table>
            <div class="starContainer">
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
              <div class="stars med-star unselect-star">&nbsp;</div>
            </div>
        </div>
  
        

      </div>
    </div>
    <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript">

(function() {
})();
    </script>
  </body>
</html>
