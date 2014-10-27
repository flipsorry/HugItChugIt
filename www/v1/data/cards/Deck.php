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
        return ($index % 13) + 1;
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
        if ($rank == 1) $this->display = 'A';
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
    
    function __construct() {
        $this->cards = array();
    }
    
    function push($card) {
        array_push($this->cards, $card);
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
}

?>
