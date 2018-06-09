<?php
class Hand{
    /*
    * cards -> array with card objects
    * value -> int
    *
    * __construct(card object)
    *
    */

    public $cards;
    public $value;

    function __construct($card1) {
        //starts an array with this card
        $this->cards = array($card1);
        //add the card value to the Hand value
        $this->value = $card1->value;
    }

    // addCardToHand(card object) 
    /**
     * @param card
     * this function adds a card to the hand and checks if the hand value is over 21, if so,
     * it will check if there is any card wih the value of 11 ('A') and will change it to 1
     */
    public function addCardToHand($card){
        // adds card to array 
        array_push($this->cards,$card);
        // added card value to value
        $this->value += $card->value;
        //checks if hand is over 21
        if($this->value > 21){
            //search for an A so it can change his value to 1 instead of 11 so the user dont get over 21
            for($i = 0;$i < count($this->cards); $i++){
                if($this->cards[$i]->value == 11){
                    //changes A value to 1
                    $this->cards[$i]->value = 1;
                    //removes 10 values from the value because 11-1 = 10
                    $this->value -= 10;
                    //if value is under or equal to 21 it gets out of the for loop, else it will run until the end,
                    //searching for another A
                    if($this->value <= 21){
                        break;
                    }
                }
            }
        }
    }

}

?>