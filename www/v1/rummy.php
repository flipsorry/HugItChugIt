<?php 
    $user = $_GET['user']; 
    $isMobile = $_GET['isMobile'];
    $otherHand = (strcmp($user, 'liem') == 0) ? 'sarahsHand' : 'liemsHand';
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Happy Birthday Sarah!</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <link rel="apple-touch-icon" href="img/birthday-icon.jpg" />
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
        .smallCard {
            width: 2rem;
            height: 3rem;
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
        .highlighted {
            background-color: #A1E5FF;
        }
        .hide {
            display: none;
        }
        .higherIndex {
            z-index: 100;
        }
        .middleIndex {
            z-index: 50;
        }
        .hiddenCard {
            top: -100px;
        }
        #container {
            padding-left: 10px;
        }
    </style>

    <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script src="http://code.jquery.com/ui/1.8.21/jquery-ui.min.js"></script>
    <script src="js/jquery.ui.touch-punch.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </head>
  <body>
  <div id="middleBar" style="height: 140px; border-left: 1px solid #fff; position: absolute; top:20px;"></div>
  <div id="infoBar" style="position: absolute; top:161px; left: 380px;">
      <button class="btn btn-info"><span id="whosTurn"><?= $user ?></span>'s turn</button>
      <button class="btn btn-success" id="otherHand"></button>
      <button class="btn" id="refreshButton" style="padding: 3px 5px; font-size: 20px">&#8635;</button>
      <a href="/v1/rummy.php?user=<?= $user ?>">
        
      </a>
  </div>
  <button class="btn hide" id="pickupButton" style="position: absolute; top:280px; left: 470px;">Pickup</button>
  <button class="btn hide" id="discardButton" style="position: absolute; top:280px; left: 470px;">Discard</button>
  <button class="btn hide" id="tripsButton" style="position: absolute; top:240px; left: 470px;">Play Trips</button>
  <button class="btn hide" id="runButton" style="position: absolute; top:200px; left: 470px;">Play Run</button>
  <div id="container">
      
      <div class="card top" id="cardTop" style="top: 180px">
      </div>
      
      <div class="card hiddenCard" id="emptyCard">
        <div class="symbol"></div>
        <div class="suitsymbol"></div>
        <div class="symbolBottom"></div>
        <div class="suitBottom"></div>
      </div>
    </div>
    <div id="gameOverAlert" class="alert alert-info hide" style="width: 450px; position:absolute; left: 25px; top: 138px; z-index: 200">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <b>Game Over! Game Score:</b>
        <br /> 
      <span id="finalScore">
        
      </span><br />
      <b>Series Score</b><br />
      <span id="seriesScore">
        
      </div>
      <span></span>
    </div>
  </body>
  
    <script type="text/javascript">

(function(w) {
   var user = '<?= $user ?>';
   var myHandMetadata = user + 'sHand';
   var otherHand = '<?= $otherHand ?>';
   var isMobile = '<?= $isMobile ?>';
   var leftOffset = 10;
   var middleOffset = 283;
   var $container = $("#container");
   var $cardTop = $("#cardTop");
   var $discardButton = $("#discardButton");
   var $tripsButton = $("#tripsButton");
   var $pickupButton = $("#pickupButton");
   var $runButton = $("#runButton");
   var $whosTurn = $("#whosTurn");
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

   var executeAction = function(action, optionalParams, isHtml) {
       var data = {
               user : user, 
               action: action,
               breakCache: new Date().toString()
               };
       if (optionalParams) {
           for (var param in optionalParams) {
               data[param] = optionalParams[param];
           }
       } 
       return $.ajax({
           url: "/v1/ajax/cards/executeAction.php",
           data: data,
           dataType: isHtml ? "html" : "json"
         });
    }

   var Game = function() {
       var whosTurn;
       var turnState;
       var playedCards = PlayedCards();
       var isCardTopClickable = false;
       var myHandClickable = false;
       var actionClickable = false;
       var communityIndexSelected = -1;

       var handSelected = [];


       var enablePlayClick = function($button, action) {
           $button.unbind('click');
           $button.click(function() {
               if (! actionClickable) return;
               actionClickable = false;
               var cardsToPlay = JSON.stringify(handSelected);
               executeAction(action, {cardsToPlay: cardsToPlay}, true)
               .done(function() {
                   disableButtons(false);
               })
               .always(function() {
                   actionClickable = true;
               });
           });
       };

       var disableButtons = function(isChangeTurn) {
           $tripsButton.hide();
           $runButton.hide();
           $discardButton.hide();
           $tripsButton.unbind('click');
           $runButton.unbind('click');
           $discardButton.unbind('click');
           handSelected = [];
           if (isChangeTurn) {
               myHandClickable = false;
               myHand.makeUnClickable();
           }
           getCurrentState();
       };

       var handClickedCallback = function(cardClicked, selected) {
           if (selected) {
               handSelected.push(cardClicked);
           } else {
               var index = handSelected.indexOf(cardClicked);
               handSelected.splice(index, 1);
           }
           if (handSelected.length == 1) {
               $discardButton.show();
               actionClickable = true;
               $discardButton.click(function() {
                   if (! actionClickable) return;
                   actionClickable = false;
                   var discardCard = JSON.stringify(handSelected[0])
                   executeAction('DISCARD', {discardCard: discardCard})
                   .done(function() {
                       disableButtons(true);
                   })
                   .always(function() {
                       actionClickable = true;
                   });
                   
               });
           } else {
               $discardButton.hide();
               $discardButton.unbind('click');
           }

           if (handSelected.length > 0) {
               $tripsButton.show();
               $runButton.show();
               enablePlayClick($tripsButton, 'PLAY_TRIPS');
               enablePlayClick($runButton, 'PLAY_RUN');
           } else {
               $tripsButton.hide();
               $runButton.hide();
               $tripsButton.unbind('click');
               $runButton.unbind('click');
           }
       };

       var communityCardClicked = function(card, selected, index, cards) {
           if (communityIndexSelected == -1) {
               communityIndexSelected = index;
               var cardsToPickup = [];
               for (var i = index; i < cards.length; i++) {
                   cards[i].select();
                   cardsToPickup.push(cards[i]);
               }
               $pickupButton.show();
               $pickupButton.click(function() {
                   var cardsToPickupJson = JSON.stringify(cardsToPickup);
                   executeAction('PICKUP_COMMUNITY', {cardsToPickup: cardsToPickupJson}, true)
                   .done(function(results) {
                       isCardTopClickable = false;
                       $cardTop.unbind('click');
                       $pickupButton.hide();
                       $pickupButton.unbind('click');
                       turnState = 'PICKED_UP';
                       getCurrentState();
                   });
               });
           } else if (index == communityIndexSelected) {
               communityIndexSelected = -1;
               for (var i = index; i < cards.length; i++) {
                   cards[i].unselect();
               }
               $pickupButton.hide();
               $pickupButton.unbind('click');
           }
       };

       var myHand = Hand(0, 250, 30, false, 100, true, handClickedCallback, true);
       var communityHand = Hand(60, 180, 30, false, 50, false, communityCardClicked, false);

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

               // Hook up the community cards being picked up
               communityIndexSelected = -1;
               communityHand.makeCardsClickable();
           }
           if (turnState == 'PICKED_UP' && ! myHandClickable) {
               myHandClickable = true;
               myHand.makeCardsClickable();
           }
       }
       
       var getCurrentState = function(){
           getMetadata([myHandMetadata, 'communityCards' , 'whosTurn', 'turnState', otherHand]).done(function(results) {
               var myCardsJson = jQuery.parseJSON(results[myHandMetadata])['cards'];
               whosTurn = results['whosTurn'];
               turnState = results['turnState'];
               communityCardsJson = jQuery.parseJSON(results['communityCards']);
               communityHandJson = communityCardsJson['communityHand']['cards'];
               $("#loader").hide();
               myHand.refreshCards(myCardsJson);
               communityHand.refreshCards(communityHandJson);
               playedCards.drawCards(communityCardsJson['sarahsPlayed'], communityCardsJson['liemsPlayed']);
               if (whosTurn == user) {
                   setTurnState(whosTurn, turnState);
               }
               if (whosTurn == 'GAME_OVER') {
                   $whosTurn.parent().html("Game Over");
                   getMetadata(['liemsScore', 'sarahsScore', 'liemsSeries', 'sarahsSeries']).done(function(results) {
                       $("#finalScore").html("Sarah: " + results['sarahsScore'] + " - Liem: " + results['liemsScore']);
                       $("#seriesScore").html("Sarah: " + results['sarahsSeries'] + " - Liem: " + results['liemsSeries']);
                       $("#gameOverAlert").show();
                   });
               } else {
                   $whosTurn.html(whosTurn);
               }
               var otherHandJson = jQuery.parseJSON(results[otherHand]);
               $("#otherHand").html(otherHandJson.cards.length);
           });
       };
       getCurrentState();
       return {
           getCurrentState: getCurrentState
       };
   };

   var PlayedCards = function() {
       var sarahsShowing = [];
       var liemsShowing = [];

       var deleteHands = function(hands) {
           for (var i = 0; i < hands.length; i++) {
               hands[i].deleteCards();
           }
       };

       var drawNewCards = function(show, played, xBase) {
           var xOffset = 0;
           var handsShowed = 0;
           for (var i = 0; i < played.length; i++) {
               var yOffset = Math.floor(handsShowed / 3) * 55;
               if ((handsShowed % 3) == 0) xOffset = 0;
               var cards = played[i]['cards'];
               // ofset for each "deck"
               var newHand = new Hand(xBase + xOffset,yOffset,15, true, null, false);
               newHand.refreshCards(cards);
               xOffset += 25 + (cards.length * 15);
               show.push(newHand);
               handsShowed++;
           }
       };
              
       return {
           drawCards: function(sarahsPlayed, liemsPlayed) {
               deleteHands(sarahsShowing);
               deleteHands(liemsShowing);
               sarahsShowing = [];
               liemsShowing = [];
               drawNewCards(sarahsShowing, sarahsPlayed, 0);
               drawNewCards(liemsShowing, liemsPlayed, middleOffset);
           }
       }
   };

   var Hand = function(x, y, xStep, useSmallCards, higherIndex, draggable, handClickedCallback, shouldSwitchSelected) {
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
       };

       var makeCardsClickable = function() {
           for (var i = 0; i < cards.length; i++) {
               var card = cards[i];
               card.makeClickable(handClickedCallback, card, i, cards, shouldSwitchSelected);
           }
       };
       var makeUnClickable = function() {
           for (var i = 0; i < cards.length; i++) {
               var card = cards[i];
               card.makeUnClickable();
           }
       };

       var moveCardToEnd = ! draggable ? null :  function(index) {
           var moveCard = cards.splice(index, 1);
           cards.push(moveCard[0]);
           makeUnClickable();
           makeCardsClickable();
           refreshXAxis();
       };
       
       var addIfNewCard = function(cardJson) {
           var foundCard = doesListContainCard(cards, cardJson);
           if (! foundCard) {
               var card = Card(cardJson.suit, cardJson.rank, cardJson.display, useSmallCards, higherIndex, moveCardToEnd);
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
               if (higherIndex) { card.setZIndex(higherIndex + i);}
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
           makeCardsClickable: makeCardsClickable,
           makeUnClickable: makeUnClickable,
           deleteCards: function() {
               for (var i = 0; i < cards.length; i++) {
                   var card = cards[i];
                   card.getDom().remove();
               }
           }
       };
   }

   var Card = function(suit, rank, display, useSmallCard, indexClass, draggable) {
       var selected = false;
       var xOffset;
       var yOffset;
       var $dom = $("#emptyCard").clone();
       if (useSmallCard) {
           $dom.addClass("smallCard");
       }
       if (indexClass) {
           $dom.css({"z-index": indexClass});
       }
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
           setZIndex: function(index) {
               if (index) {
                   $dom.css({"z-index": index});
               }
           },
           select: function() {
               displayYOffset(yOffset - 20);
           },
           unselect: function() {
               displayYOffset(yOffset);
           },
           makeClickable: function(handClickedCallback, card, index, cards, shouldSwitchSelected) {
               $dom.unbind('click');
               $dom.unbind('touchend');
               $dom.unbind('touchstart');

               if (draggable && isMobile == 'true') {
                   $dom.bind('touchend', function(event) {
                       $dom.removeClass("highlighted");
                       var touch = event.originalEvent.changedTouches[0];
                       w.ee = event;
                       if (touch.pageX - xOffset > 50) {
                           console.log(index);
                           event.preventDefault();
                           draggable(index);
                       } else {
                           if (shouldSwitchSelected)
                               switchSelected();
                           handClickedCallback(card, selected, index, cards);
                       }
                   });
                   $dom.bind('touchstart', function(event) {
                       $dom.addClass("highlighted");
                   });
               } else {
                   $dom.click(function() {
                       if (shouldSwitchSelected)
                           switchSelected();
                       handClickedCallback(card, selected, index, cards);
                   });
               }
           },
           makeUnClickable: function() {
               $dom.unbind('click');
               $dom.unbind('touchend');
               $dom.unbind('touchstart');
           }
       };
   }

   w.game = Game();
   $("#refreshButton").click(function() { w.game.getCurrentState();});
    
})(window);
    </script>
  
</html>