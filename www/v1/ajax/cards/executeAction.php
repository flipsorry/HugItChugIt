<?php 
    require_once $_SERVER['DOCUMENT_ROOT'] . '/v1/data/mysql/MetadataDao.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/v1/data/cards/Deck.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/v1/data/json/JsonMapper.php';
    $metadataDao = new MetadataDao();
    $action = $_GET["action"];
    $user = $_GET["user"];
    
    $whosTurn = $metadataDao->getRequest('whosTurn');
    $whosHand = $user . 'sHand';
    if (strcmp($user, $whosTurn) !== 0) {
        echo "not your turn!";
        http_response_code(400);
        return;
    }
    
    $turnState = $metadataDao->getRequest('turnState');
    $mapper = new JsonMapper();
    
    $currentHandDecoded = json_decode($metadataDao->getRequest($whosHand));
    $currentHand = $mapper->map($currentHandDecoded, new Hand());
    
    if (strcmp($action, 'PICKUP_DECK') == 0) {
        if (strcmp($turnState, 'NOT_PICKED_UP') == 0) {
            
            $currentDeckDecoded = json_decode($metadataDao->getRequest('currentDeck'));
            $currentDeck = $mapper->map($currentDeckDecoded, new Deck());
            
            // take a card off the the top of the deck and give it to the person
            $cardReturned = $currentDeck->getNextCard();
            $currentHand->push($cardReturned);
            
            
            $metadataDao->putLog('PICKUP_TRANSACTION', $user . ',' . $action . ' - ' . $cardReturned);
            
            $metadataDao->putRequest('currentDeck', json_encode($currentDeck));
            $metadataDao->putRequest($whosHand, json_encode($currentHand));
            $metadataDao->putRequest('turnState', 'PICKED_UP');
            echo json_encode($cardReturned);
            return;
        }
    }
    
    if (strcmp($action, 'DISCARD') == 0) {
        if (strcmp($turnState, 'PICKED_UP') == 0) {
            
            $discardCardDecoded = json_decode($_GET["discardCard"]);
            $discardCard = $mapper->map($discardCardDecoded, new Card());
            
            $communityCardsDecoded = json_decode($metadataDao->getRequest('communityCards'));
            $communityCards = $mapper->map($communityCardsDecoded, new CommunityCards());
            $communityHand = $communityCards->communityHand;
    
            $foundCard = $currentHand->removeIfFound($discardCard);
            if ($foundCard != null) {
                $communityHand->push($foundCard);
            } else {
                echo "Card not found in currentHand!"; http_response_code(400); return;
            }
    
    
            $metadataDao->putLog('DISCARD_TRANSACTION', $user . ',' . $action . ' - ' . $foundCard);
    
            if (strcmp($whosTurn, 'sarah') == 0)
                $metadataDao->putRequest('whosTurn', 'liem');
            else 
                $metadataDao->putRequest('whosTurn', 'sarah');
            $metadataDao->putRequest('communityCards', json_encode($communityCards));
            $metadataDao->putRequest($whosHand, json_encode($currentHand));
            $metadataDao->putRequest('turnState', 'NOT_PICKED_UP');
            
            if (sizeof($currentHand->cards) == 0) {
                $metadataDao->putRequest('whosTurn', 'GAME_OVER');
                $liemsScore = $communityCards->getScore('liem');
                $sarahsScore = $communityCards->getScore('sarah');
                $metadataDao->putLog('GAME_END', 'liemsScore: ' . $liemsScore . ', sarahsScore: ' . $sarahsScore);
                $metadataDao->putRequest('liemsScore', $liemsScore);
                $metadataDao->putRequest('sarahsScore', $sarahsScore);
                
                $liemsSeries = $metadataDao->getRequest('liemsSeries');
                $sarahsSeries = $metadataDao->getRequest('sarahsSeries');
                $liemsSeries += $liemsScore;
                $sarahsSeries += $sarahsScore;
                $metadataDao->putRequest('liemsSeries', $liemsSeries);
                $metadataDao->putRequest('sarahsSeries', $sarahsSeries);
            }
            
            echo json_encode($foundCard);
            return;
        }
    }
    
    if (strcmp($action, 'PLAY_TRIPS') == 0 || strcmp($action, 'PLAY_RUN') == 0) {
        if (strcmp($turnState, 'PICKED_UP') == 0) {
            $cardsToPlayDecoded = json_decode($_GET["cardsToPlay"]);
            $cardsToPlay = $mapper->mapArray($cardsToPlayDecoded, array(), 'Card');
            if (! $currentHand->removeAllIfFound($cardsToPlay)) {
                echo "Not all cards found in hand"; http_response_code(400); return;
            }
            
            $communityCardsDecoded = json_decode($metadataDao->getRequest('communityCards'));
            $communityCards = $mapper->map($communityCardsDecoded, new CommunityCards()); 
            
            if ($communityCards->playCards($user, $cardsToPlay, $action)) {
                $metadataDao->putLog('PLAYING_CARDS', $user . ',' . $action . ' - ' . $_GET["cardsToPlay"]);
                $metadataDao->putRequest('communityCards', json_encode($communityCards));
                $metadataDao->putRequest($whosHand , json_encode($currentHand));
                if (sizeof($currentHand->cards) == 0) {
                    $metadataDao->putRequest('whosTurn', 'GAME_OVER');
                    $liemsScore = $communityCards->getScore('liem');
                    // TODO SUBTRACTION OF SCORE
                    $sarahsScore = $communityCards->getScore('sarah');
                    $metadataDao->putLog('GAME_END', 'liemsScore: ' . $liemsScore . ', sarahsScore: ' . $sarahsScore);
                    $metadataDao->putRequest('liemsScore', $liemsScore);
                    $metadataDao->putRequest('sarahsScore', $sarahsScore);
                    
                    $liemsSeries = $metadataDao->getRequest('liemsSeries');
                    $sarahsSeries = $metadataDao->getRequest('sarahsSeries');
                    $liemsSeries += $liemsScore;
                    $sarahsSeries += $sarahsScore;
                    $metadataDao->putRequest('liemsSeries', $liemsSeries);
                    $metadataDao->putRequest('sarahsSeries', $sarahsSeries);
                }
                return; 
            } else {
                echo "Hand cannot be played!"; http_response_code(400); return;
            } 
        }
    }
    
    if (strcmp($action, 'PICKUP_COMMUNITY') == 0) {
        if (strcmp($turnState, 'NOT_PICKED_UP') == 0) {
            $cardsToPickupDecoded = json_decode($_GET["cardsToPickup"]);
            $cardsToPickup = $mapper->mapArray($cardsToPickupDecoded, array(), 'Card');
            
            $communityCardsDecoded = json_decode($metadataDao->getRequest('communityCards'));
            $communityCards = $mapper->map($communityCardsDecoded, new CommunityCards());
            $communityHand = $communityCards->communityHand;
            
            if (! $communityHand->removeAllIfFound($cardsToPickup)) {
                echo "Not all cards found in community hand"; http_response_code(400); return;
            }
            
            
            // TODO we need to validate that the person can use the top card that was removed
            $currentHand->pushCards($cardsToPickup);
            
            $metadataDao->putLog('PICKUP_COMMUNITY', $user . ',' . $action . ' - ' . $_GET["cardsToPickup"]);
            $metadataDao->putRequest('communityCards', json_encode($communityCards));
            $metadataDao->putRequest($whosHand, json_encode($currentHand));
            $metadataDao->putRequest('turnState', 'PICKED_UP');
            return;
        }
    }
    
    echo "not valid action";
    http_response_code(400);
?>