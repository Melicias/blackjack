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

    public function getCardName(){
        return $this->name . ".png";
    }
}

?>