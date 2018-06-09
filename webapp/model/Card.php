<?php
class Card{

    /*
    * name ->   String    -> card Name, match with the one in the picture
    * value ->  string    -> card value if its an 'A' value must be 11
    *
    * __construct(String ,String )
    *
    */

    public $name;
    public $value;
    
    function __construct($name,$value) {
        $this->name = $name;
        $this->value = $value;
    }

    /**
    * @return String name with '.png' at the end
    */
    public function getCardNameWithPng(){
        return $this->name . ".png";
    }
}

?>