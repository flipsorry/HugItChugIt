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
            echo json_encode($foundCard);
            return;
        }
    }
    
    echo "not valid action";
    http_response_code(400);
?>