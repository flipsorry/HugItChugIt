
<html><body>
<?php 
    require_once $_SERVER['DOCUMENT_ROOT'] . '/v1/data/mysql/MetadataDao.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/v1/data/cards/Deck.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/v1/data/json/JsonMapper.php';
    if (strcmp($_POST['action'], 'startGame') === 0) {
        $deck = new Deck();
        $deck->createNewDeck();
        
        $sarahsHand = new Hand();
        $liemsHand = new Hand();
        for ($i = 0; $i < 7; $i++) {
            $sarahsHand->push($deck->getNextCard());
            $liemsHand->push($deck->getNextCard());
        }
        
        $communityCards =new CommunityCards();
        $communityCards->communityHand->push($deck->getNextCard());
        
        $metadata = new MetadataDao();
        $deckEncoded = json_encode($deck);
        $metadata->putRequest('currentDeck', $deckEncoded);
        $metadata->putLog('CREATE_CURRENT_DECK', $deckEncoded);
        
        $sarahsHandEncoded = json_encode($sarahsHand);
        $metadata->putRequest('sarahsHand', $sarahsHandEncoded);
        $metadata->putLog('CREATE_SARAHS_HAND', $sarahsHandEncoded);
        
        $liemsHandEncoded = json_encode($liemsHand);
        $metadata->putRequest('liemsHand', $liemsHandEncoded);
        $metadata->putLog('CREATE_LIEMS_HAND', $liemsHandEncoded);
        
        $communityCardsEncoded = json_encode($communityCards);
        $metadata->putRequest('communityCards', $communityCardsEncoded);
        $metadata->putLog('CREATE_COMMUNITY_CARDS', $communityCardsEncoded);
        
        $randomNumber = rand(0, 1);
        $whoStarts = 'sarah';
        if ($randomNumber == 0) {
            $whoStarts = 'liem';
        }
        $metadata->putRequest('whosTurn', $whoStarts);
        $metadata->putRequest('turnState', 'NOT_PICKED_UP');
        $metadata->putLog('TURN_START', $whoStarts);
        //echo $encoded  . '<br />';
        //$mapper = new JsonMapper();
        //$decoded = json_decode($encoded);
        //$newDeck = $mapper->map($decoded, new Deck());
        echo $whoStarts;
        
        //echo '<br /><br />'. $encoded  . '<br />';

    }

?>


<form name="input" action="rummy-admin.php" method="post">
    <input type="radio" name="action" value="startGame">startGame<br>
    <input type="submit" value="Submit">
</form>
</body>
</html>