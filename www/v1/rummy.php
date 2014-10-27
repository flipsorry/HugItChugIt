<?php 
    $user = $_GET['user']; 
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Happy Birthdy Sarahhh</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <style>
        body {
            font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-image: url('img/cards/felt_background.png');
        }
        .card.black {
            color: #2c3e50;
        }
        .card.red {
            color: #c0392b;
        }
        .card.top {
            background-image: url('img/cards/back_card.png');
            background-size: 40px 60px;
            background-repeat: no-repeat;
        }
        .card {
            position: absolute;
            top: 0;
            left: 0;
            width: 2.5rem;
            height: 3.8rem;
            background-color: #fff;
            -webkit-border-radius: .125rem;
            border-radius: .250rem;
            -webkit-box-shadow: 0 1px 2px rgba(0,0,0,0.04);
            box-shadow: 0 1px 2px rgba(0,0,0,0.04);
            border: 1px solid #383838;
        }
        .symbol {
            position: absolute;
            top: .25rem;
            left: .25rem;
        }
        .suitsymbol {
            position: absolute;
            top: 1rem;
            left: .25rem;
            font-size: 1rem;
        }
        .symbolBottom {
            position: absolute;
            bottom: .25rem;
            right: .25rem;
            -webkit-transform: rotate(180deg);
            -moz-transform: rotate(180deg);
            -o-transform: rotate(180deg);
            -ms-transform: rotate(180deg);
            transform: rotate(180deg);
        }
        .suitBottom {
            position: absolute;
            bottom: 1rem;
            right: .25rem;
            -webkit-transform: rotate(180deg);
            -moz-transform: rotate(180deg);
            -o-transform: rotate(180deg);
            -ms-transform: rotate(180deg);
            transform: rotate(180deg);
            font-size: 1rem;
        }
        .hide {
            display: none;
        }
        .hiddenCard {
            top: -100px;
        }
        #container {
            padding-left: 10px;
        }
    </style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </head>
  <body>
  <div id="middleBar" style="height: 140px; border-left: 1px solid #fff; position: absolute; top:20px;"></div>
  <a href="/v1/rummy.php?user=<?= $user ?>">
    <button class="btn" id="refreshButton" style="position: absolute; top:20px; left: 490px; padding: 3px 5px; font-size: 20px">&#8635;</button>
  </a>
  <button class="btn hide" id="discardButton" style="position: absolute; top:280px; left: 470px;">Discard</button>
  <div id="container">
      <div class="card black">
        <div class="symbol">A</div>
        <div class="suitsymbol">&spades;</div>
        <div class="symbolBottom">A</div>
        <div class="suitBottom">&spades;</div>
      </div>
      <div class="card black" style="left: 20px">
        <div class="symbol">A</div>
        <div class="suitsymbol">&clubs;</div>
        <div class="symbolBottom">A</div>
        <div class="suitBottom">&clubs;</div>
      </div>
      <div class="card red" style="left: 40px">
        <div class="symbol">A</div>
        <div class="suitsymbol">&hearts;</div>
        <div class="symbolBottom">A</div>
        <div class="suitBottom">&hearts;</div>
      </div>
      <div class="card red" style="left: 60px">
        <div class="symbol">A</div>
        <div class="suitsymbol">&diams;</div>
        <div class="symbolBottom">A</div>
        <div class="suitBottom">&diams;</div>
      </div>
      
      <div class="card top" id="cardTop" style="top: 180px">
      </div>
      
      <div class="card hiddenCard" id="emptyCard">
        <div class="symbol"></div>
        <div class="suitsymbol"></div>
        <div class="symbolBottom"></div>
        <div class="suitBottom"></div>
      </div>
    </div>
  </body>
  
    <script type="text/javascript">

(function(w) {
   var user = '<?= $user ?>';
   var myHandMetadata = user + 'sHand';
   var leftOffset = 10;
   var middleOffset = 283;
   var $container = $("#container");
   var $cardTop = $("#cardTop");
   var $discardButton = $("#discardButton");
   $cardTop.css({left: leftOffset + "px"});
   $("#middleBar").css({left: middleOffset + "px"});

   var getMetadata = function(namesArray) {
      var namesString = namesArray[0];
      for (var i = 1; i < namesArray.length; i++) {
          namesString += "," + namesArray[i];
      }
      return $.ajax({
          url: "/v1/ajax/cards/getMetadata.php",
          data: {
              names: namesString
          },
          dataType: "json"
        });
   }

   var executeAction = function(action, discardCard) {
       return $.ajax({
           url: "/v1/ajax/cards/executeAction.php",
           data: {
               user: user,
               action: action,
               discardCard: discardCard
           },
           dataType: "json"
         });
    }

   var Game = function() {
       var whosTurn;
       var turnState;
       var myHand = Hand(0, 250, 30);
       var communityHand = Hand(60, 180, 30);
       var isCardTopClickable = false;
       var myHandClickable = false;
       var discardClickable = false;

       var handSelected = [];

       var handClickedCallback = function(card, selected) {
           if (selected) {
               handSelected.push(card);
           } else {
               var index = handSelected.indexOf(card);
               handSelected.splice(index, 1);
           }
           if (handSelected.length == 1) {
               $discardButton.show();
               discardClickable = true;
               $discardButton.click(function() {
                   if (! discardClickable) return;
                   discardClickable = false;
                   executeAction('DISCARD', JSON.stringify(card))
                   .done(function() {
                       $discardButton.hide();
                       $discardButton.unbind('click');
                       myHand.makeUnClickable();
                       getCurrentState();
                   })
                   .always(function() {
                       discardClickable = true;
                   });
                   
               });
           } else {
               $discardButton.hide();
               $discardButton.unbind('click');
           }
       };

       var setTurnState = function(whosTurn, turnState) {
           if (turnState == 'NOT_PICKED_UP' && ! isCardTopClickable) {
               isCardTopClickable = true;
               $cardTop.click(function() {
                   executeAction('PICKUP_DECK').done(function(results) {
                       isCardTopClickable = false;
                       $cardTop.unbind('click');
                       turnState = 'PICKED_UP';
                       getCurrentState();
                   });
               });
           }
           if (turnState == 'PICKED_UP' && ! myHandClickable) {
               myHandClickable = true;
               myHand.makeCardsClickable(handClickedCallback);
           }
       }
       
       var getCurrentState = function(){
           getMetadata([myHandMetadata, 'communityCards' , 'whosTurn', 'turnState']).done(function(results) {
               var myCardsJson = jQuery.parseJSON(results[myHandMetadata])['cards'];
               whosTurn = results['whosTurn'];
               turnState = results['turnState'];
               communityCardsJson = jQuery.parseJSON(results['communityCards']);
               communityHandJson = communityCardsJson['communityHand']['cards'];
               $("#loader").hide();
               myHand.refreshCards(myCardsJson);
               communityHand.refreshCards(communityHandJson);
               if (whosTurn == user) {
                   setTurnState(whosTurn, turnState);
               }
           });
       };
       getCurrentState();
       return {
           getCurrentState: getCurrentState
       };
   };

   var Hand = function(x, y, xStep) {
       var yOffset = y;
       var xOffset = x;
       var xOffsetStep = xStep;
       var cards = [];

       var doesListContainCard = function (cardList, cardToFind) {
           var foundCard = false;
           for(var i = 0; i < cardList.length; i++) {
               var deckCard = cardList[i];
               if (cardToFind.suit == deckCard.suit && cardToFind.rank == deckCard.rank)
                   foundCard = true;
           }
           return foundCard;
       }
       
       var addIfNewCard = function(cardJson) {
           var foundCard = doesListContainCard(cards, cardJson);
           if (! foundCard) {
               var card = Card(cardJson.suit, cardJson.rank, cardJson.display);
               card.setYOffset(yOffset);
               cards.push(card);
               $container.append(card.getDom());
           }
       };
       var deleteMissingCards = function(cardsJson) {
           for (var i = cards.length -1; i >= 0; i--) {
               var card = cards[i];    
               if (! doesListContainCard(cardsJson, card)) {
                   card.getDom().remove();
                   cards.splice(i, 1);
               }
           }
       }

       var refreshXAxis = function() {
           for(var i = 0; i < cards.length; i++) {
               var card = cards[i];
               card.setXOffset((xOffsetStep * i) + leftOffset + xOffset);
           }
       };
       
       return {
           refreshCards: function(cardsJson) {
               for (var i = 0; i < cardsJson.length; i++) {
                   var cardJson = cardsJson[i];    
                   addIfNewCard(cardJson);
               }
               deleteMissingCards(cardsJson);
               refreshXAxis();
           },
           makeCardsClickable: function(handClickedCallback) {
               for (var i = 0; i < cards.length; i++) {
                   var card = cards[i];
                   card.makeClickable(handClickedCallback, card);
               }
           },
           makeUnClickable: function() {
               for (var i = 0; i < cards.length; i++) {
                   var card = cards[i];
                   card.makeUnClickable();
               }
           }
       };
   }

   var Card = function(suit, rank, display) {
       var selected = false;
       var xOffset;
       var yOffset;
       var $dom = $("#emptyCard").clone();
       $dom.attr("id", rank + suit);
       $dom.find(".symbol").html(display);
       $dom.find(".symbolBottom").html(display);
       $dom.find(".suitsymbol").html("&" + suit + ";");
       $dom.find(".suitBottom").html("&" + suit + ";");
       if (suit == 'hearts' || suit == 'diams') {
           $dom.removeClass("black");
           $dom.addClass("red");
       }

       var displayYOffset = function(offset) {
           $dom.css({top: offset + "px"});
       };

       var switchSelected = function() {
           selected = ! selected;
           if (selected) {
               displayYOffset(yOffset - 20);
           } else {
               displayYOffset(yOffset);
           }
       };

       return {
           suit: suit,
           rank: rank,
           display: display,
           getDom: function() {return $dom;},
           setYOffset: function(offset) {
               yOffset = offset;
               displayYOffset(yOffset);
           },
           setXOffset: function(offset) {
               xOffset = offset;
               $dom.css({left: offset + "px"});
           },
           setOffset: function(x, y) {
               xOffset = x;
               yOffset = y;
               $dom.css({left: x + "px", top: y + "px"});
           },
           makeClickable: function(handClickedCallback, card) {
               $dom.click(function() {
                   switchSelected();
                   handClickedCallback(card, selected);
               });
           },
           makeUnClickable: function() {
               $dom.unbind('click');
           }
       };
   }

   w.game = Game();
    
})(window);
    </script>
  
</html>