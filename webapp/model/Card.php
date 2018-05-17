<?php
class Card{

    /*
    * name -> String
    * value -> string
    *
    * __construct(String ,String )
    *
    *
    *
    */

    public $name;
    public $value;
    
    function __construct($name,$value) {
        $this->name = $name;
        $this->value = $value;
    }

    //returns the card name with '.png' at the end
    public function getCardNameWithPng(){
        return $this->name . ".png";
    }
}

?>