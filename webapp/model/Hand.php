<?php
class Hand{
    /*
    * cards -> array with card objects
    * value -> int
    * __construct(card object, card object)
    *
    *
    *
    *
    *
    */

    public $cards;
    public $value;

    function __construct($card1,$card2) {
        $this->cards = array($card1,$card2);
        $this->value = $card1->value;
        $this->value += $card2->value;
    }

    public function addCardToHand($card){
        array_push($this->cards,$card);
    }

}

?>