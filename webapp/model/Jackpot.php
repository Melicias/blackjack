<?php

class Jackpot extends \ActiveRecord\Model
{

    static $table_name = "jackpot10";

    /*
    * value_won   int
	* username    String
    * id_user     int
    *
    * bj_date     date      default: CURRENT_TIMESTAMP -> no need to send this field to the db
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