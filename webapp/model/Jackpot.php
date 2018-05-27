<?php

class Jackpot extends \ActiveRecord\Model
{

    static $table_name = "jackpot10";

    /*
    * value_won   int
	* bj_date     date 
	* username    String
    * id_user     int
    *
    * no order in construct
    */

    /**
	 * Validates a field is not null and not blank.
     */
    static $validates_presence_of = array(
        array('value_won', 'message' => 'Deverá preencher este campo!'),
        array('username', 'message' => 'Deverá preencher este campo!'),
        array('id_user', 'message' => 'Deverá preencher este campo!')
    );

}

?>