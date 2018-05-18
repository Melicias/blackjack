<?php

class Jackpot extends \ActiveRecord\Model
{

    static $table_name = "jackpot";

    /*
    * value_won   int
	* bj_date     date 
	* username    String
    * 
    *
    * no order in construct
    */

    /**
	 * Validates a field is not null and not blank.
     */
    static $validates_presence_of = array(
        array('value_won', 'message' => 'Deverá preencher este campo!'),
        array('bj_date', 'message' => 'Deverá preencher este campo!'),
        array('username', 'message' => 'Deverá preencher este campo!')
    );

}

?>