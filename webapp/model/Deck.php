<?php
class Deck{

    /*
    * $cards -> array of cards objects
    * __construct()
    *
    */

    public $cards;
    
    function __construct() {
        //insert the cards into the deck
        $deck1 = $this->inicializeDeck();
        $deck2 = $this->inicializeDeck();
        $deck3 = $this->inicializeDeck();
        $deck4 = $this->inicializeDeck();
        $deck5 = $this->inicializeDeck();
        // joins all decks into 1
        $this->cards = array_merge($deck1,$deck2,$deck3,$deck4,$deck5);
        //shuffle the deck
        shuffle($this->cards);
    }

    /**
     * @return card the first element in the array and removes it
     * @return null if there is no more cards in the deck 
     */
    function giveCardToUser(){
        if(count($this->cards)>0)
            return array_shift($this->cards);
        return null;
    }

    /**
     * @return array cards
     */
    public function getDeck(){
        return $this->cards;
    }

    /**
     * @return array new deck
     */

    public function inicializeDeck(){
        //card  __construct($name,$value)
        $deck = array(
            //all clubs
            new card("cardClubs2",2),
            new card("cardClubs3",3),
            new card("cardClubs4",4),
            new card("cardClubs5",5),
            new card("cardClubs6",6),
            new card("cardClubs7",7),
            new card("cardClubs8",8),
            new card("cardClubs9",9),
            new card("cardClubs10",10),
            new card("cardClubsJ",10),
            new card("cardClubsQ",10),
            new card("cardClubsK",10),
            new card("cardClubsA",11),
            //all diamonds
            new card("cardDiamonds2",2),
            new card("cardDiamonds3",3),
            new card("cardDiamonds4",4),
            new card("cardDiamonds5",5),
            new card("cardDiamonds6",6),
            new card("cardDiamonds7",7),
            new card("cardDiamonds8",8),
            new card("cardDiamonds9",9),
            new card("cardDiamonds10",10),
            new card("cardDiamondsJ",10),
            new card("cardDiamondsQ",10),
            new card("cardDiamondsK",10),
            new card("cardDiamondsA",11),
            //all hearths
            new card("cardHearts2",2),
            new card("cardHearts3",3),
            new card("cardHearts4",4),
            new card("cardHearts5",5),
            new card("cardHearts6",6),
            new card("cardHearts7",7),
            new card("cardHearts8",8),
            new card("cardHearts9",9),
            new card("cardHearts10",10),
            new card("cardHeartsJ",10),
            new card("cardHeartsQ",10),
            new card("cardHeartsK",10),
            new card("cardHeartsA",11),
            //all spades
            new card("cardSpades2",2),
            new card("cardSpades3",3),
            new card("cardSpades4",4),
            new card("cardSpades5",5),
            new card("cardSpades6",6),
            new card("cardSpades7",7),
            new card("cardSpades8",8),
            new card("cardSpades9",9),
            new card("cardSpades10",10),
            new card("cardSpadesJ",10),
            new card("cardSpadesQ",10),
            new card("cardSpadesK",10),
            new card("cardSpadesA",11)
        );
        return $deck;
    }

}

?>