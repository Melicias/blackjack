<?php

class User extends \ActiveRecord\Model
{

    static $table_name = "users";

    /*
    * is_admin   int
    * username   String
    * full_name  String
    * email      String
    * pass       String
    * Birthday   Date
    * money      int
    *
    * no order in construct
    */

    /**
	 * Validates a field is not null and not blank.
     */
    static $validates_presence_of = array(
        array('email', 'message' => 'Deverá preencher este campo!'),
        array('full_name', 'message' => 'Deverá preencher este campo!'),
        array('username', 'message' => 'Deverá preencher este campo!'),
        array('pass', 'message' => 'Deverá preencher este campo!'),
        array('birthday', 'message' => 'Deverá preencher este campo!')
    );


    /**
	 * Validates the uniqueness of a value.
     */
    static $validates_uniqueness_of = array(
        array(array('username'), 'message' => 'O username já existe!'),
        array(array('email'), 'message' => 'O email já está registado!')
    );
}

?>