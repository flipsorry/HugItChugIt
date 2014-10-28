<?php

class Deck {
    /**
     * @var Card[]
     */
    public $cards;
    
    public function createNewDeck() {
        $this->cards = array();
        for ($i = 0; $i < 52; $i++) {
            $card = new Card($this->getSuit($i), $this->getRank($i));
            array_push($this->cards, $card);
        }
        shuffle($this->cards);
    }
    
    public function getNextCard() {
        return array_pop($this->cards);
    }
    
    private function getRank($index) {
        return ($index % 13) + 2;
    }
    private function getSuit($index) {
        $division = floor($index / 13);
        if ($division == 0) return 'spades';
        if ($division == 1) return 'clubs';
        if ($division == 2) return 'hearts';
        if ($division == 3) return 'diams';
    }
}

class Card {
    public $suit;
    public $rank;
    public $display;
    function __construct($suit, $rank) {
        $this->suit = $suit;
        $this->rank = $rank;
        if ($rank == 14) $this->display = 'A';
        elseif ($rank == 11) $this->display = 'J';
        elseif ($rank == 12) $this->display = 'Q';
        elseif ($rank == 13) $this->display = 'K';
        else $this->display = $rank;
    }
    function __toString() {
        return $this->display . ':' . $this->suit;
    }
}

class Hand {
    /**
     * @var Card[]
     */
    public $cards;
    public $isRun;
    
    function __construct() {
        $this->cards = array();
        $this->isRun = false;
    }
    
    function setCards($cards) {
        $this->cards = $cards;
        return $this;
    }
    
    function setIsRun($isRun) {
        $this->isRun = $isRun;
        return $this;
    }
    
    function getScore() {
        for ($j = 0; $j < sizeof($this->cards); $j++) {
            $card = $this->cards[$j];
            if ($card->rank == 14) {
                $total += 15;
            } else if($card->rank >= 10) {
                $total += 10;
            } else {
                $total += 5;
            }
        }
        return $total;
    }
    
    function push($card) {
        array_push($this->cards, $card);
    }
    
    function pushCards($cards) {
        for ($i = 0; $i < sizeof($cards); $i++) {
            array_push($this->cards, $cards[$i]);
        }
    }
    
    function removeIfFound($otherCard) {
        for ($i = 0; $i < sizeof($this->cards); $i++) {
            $card = $this->cards[$i];
            if (strcmp($card->suit, $otherCard->suit) == 0
                && strcmp($card->rank, $otherCard->rank) == 0) {
                array_splice($this->cards, $i, 1);
                return $card;
            }
        }
        return null;
    }
    
    function removeAllIfFound($cardsToFind) {
        for ($i = 0; $i < sizeof($cardsToFind); $i++) {
            $cardToFind = $cardsToFind[$i];
            $foundCard = $this->removeIfFound($cardToFind);
            if ($foundCard == null) {
                return false;
            }
        }
        return true;
    }
    
    function __toString() {
        return json_encode($this);
    }
}

class CommunityCards {
    
    /**
     * @var Hand
     */
    public $communityHand;
    
    /**
     * @var Hand[]
     */
    public $liemsPlayed;
    /**
     * @var Hand[]
     */
    public $sarahsPlayed;
    
    function __construct() {
        $this->communityHand = new Hand();
        $this->liemsPlayed = array();
        $this->sarahsPlayed = array();
    }
    
    public function getScore($user, $personsHand) {
        if (strcmp($user, 'liem') == 0) {
            return $this->getScoreForUser($this->liemsPlayed);
        } else {
            return $this->getScoreForUser($this->sarahsPlayed);
        }
    }
    
    private function getScoreForUser($hands) {
        $total = 0;
        for ($i = 0; $i < sizeof($hands); $i++) {
            $hand = $hands[$i];
            $total += $hand->getScore();
        }
        return $total;
    }
    
    public function playCards($user, $cards, $action) {
        $newHand = $this->createValidHand($cards, $action);
        if ($newHand != null) {
            if (strcmp($user, 'liem') == 0) {
                array_push($this->liemsPlayed, $newHand);
            }
            if (strcmp($user, 'sarah') == 0) {
                array_push($this->sarahsPlayed, $newHand);
            }
            return true;
        }
        
        return $this->addCardToDeck($user, $cards, $action);
    }
    
    private function addCardToDeck($user, $cards, $action) {
        for ($i = 0; $i < sizeof($cards); $i++) {
            $card = $cards[$i];
            $thisUsersPlayed = null;
            $otherUsersPlayed = null;
            if (strcmp($user, 'liem') == 0) {
                $thisUsersPlayed = &$this->liemsPlayed;
                $otherUsersPlayed = $this->sarahsPlayed;
            } else {
                $thisUsersPlayed = &$this->sarahsPlayed;
                $otherUsersPlayed = $this->liemsPlayed;
            }
            if (strcmp($action, 'PLAY_TRIPS') == 0) {
                if (! $this->addTrips($user, $card, $thisUsersPlayed, $otherUsersPlayed)) {
                    return false;
                }
            } else {
                if (! $this->addRun($user, $card, $thisUsersPlayed, $otherUsersPlayed)) {
                    return false;
                }
            }
        }
        return true;
    }
    
    private function addRun($user, $card, &$thisUsersPlayed, $otherUsersPlayed) {
        for ($i = 0; $i < sizeof($thisUsersPlayed); $i++) {
            $hand = $thisUsersPlayed[$i];
            if ($hand->isRun) {
                
                for ($j = 0; $j < sizeof($hand->cards); $j++) {
                    if (strcmp($hand->cards[$j]->suit, $card->suit) == 0 &&
                            ($hand->cards[$j]->rank + 1 == $card->rank
                             || $hand->cards[$j]->rank - 1 == $card->rank
                             || ($hand->cards[$j]->rank == 2 && $card->rank == 14)
                            )
                       ) {
                        if ($hand->cards[$j]->rank == 2 && $card->rank == 14) $card->rank = 1;
                        $hand->push($card);
                        return true;
                    }
                }
            }
        }
    
        for ($i = 0; $i < sizeof($otherUsersPlayed); $i++) {
            $hand = $otherUsersPlayed[$i];
            if ($hand->isRun) {
            
                for ($j = 0; $j < sizeof($hand->cards); $j++) {
                    if (strcmp($hand->cards[$j]->suit, $card->suit) == 0 &&
                            ($hand->cards[$j]->rank + 1 == $card->rank
                                    || $hand->cards[$j]->rank - 1 == $card->rank
                                    || ($hand->cards[$j]->rank == 2 && $card->rank == 14)
                            )
                    ) {
                        if ($hand->cards[$j]->rank == 2 && $card->rank == 14) $card->rank = 1;
                        $newHand = (new Hand())->setIsRun(true);
                        $newHand->push($card);
                        $thisUsersPlayed[] = $newHand;
                        return true;
                    }
                }
            }
        }
        return false;
    }
    
    private function addTrips($user, $card, &$thisUsersPlayed, $otherUsersPlayed) {
        for ($i = 0; $i < sizeof($thisUsersPlayed); $i++) {
            $hand = $thisUsersPlayed[$i];
            if (! $hand->isRun && $hand->cards[0]->rank == $card->rank) {
                $hand->push($card);
                return true;
            }
        }
        
        for ($i = 0; $i < sizeof($otherUsersPlayed); $i++) {
            $hand = $otherUsersPlayed[$i];
            if (! $hand->isRun && $hand->cards[0]->rank == $card->rank) {
                $newHand = (new Hand())->setIsRun(false);
                $newHand->push($card);
                $thisUsersPlayed[] = $newHand;
                return true;
            }
        }
        return false;
    }
    
    private function createValidHand($cards, $action) {
        if (sizeof($cards) == 3) {
            if (strcmp($action, 'PLAY_TRIPS') == 0) {
                $cardRank = $cards[0]->rank;
                for ($i = 0; $i < sizeof($cards); $i++) {
                    $card = $cards[$i];
                    if ($card->rank != $cardRank) {
                        return null;
                    }
                }
                return (new Hand())->setCards($cards)->setIsRun(false);
            }
            
            if (strcmp($action, 'PLAY_RUN') == 0) {
                $cardSuit = $cards[0]->suit;
                $ranks = array();
                for ($i = 0; $i < sizeof($cards); $i++) {
                    $card = $cards[$i];
                    if ($card->suit != $cardSuit) {
                        return null;
                    }
                    array_push($ranks, $card->rank);
                }
                sort($ranks);
                $rankLength = sizeof($ranks);
                for ($i = 1; $i < $rankLength; $i++) {
                    echo '('.$ranks[$i].')'; 
                    if($ranks[$i] - 1 != $ranks[$i - 1]) {
                        // check if the last card is an ace
                        // BUG this only works if you play 3 cards at once
                        if (! ($ranks[$i] == 14 && $ranks[0] == 2)) {
                            return null;
                        } else {
                            for ($i = 0; $i < sizeof($cards); $i++) 
                                if ($cards[$i]->rank == 14) $cards[$i]->rank = 1;
                        }
                    }
                }
                return (new Hand())->setCards($cards)->setIsRun(true);
            }
        }
        return null;
    }
}

?>
