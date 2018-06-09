<?php

class User extends \ActiveRecord\Model
{

    static $table_name = "users";

    /*
    * is_admin   int  0 -> no admin | 1 -> admin | 2 -> superAdmin | default: 0
    * username   String
    * full_name  String
    * email      String
    * pass       String
    * Birthday   Date
    * money      int
    * block      int  0 -> no block | 1 -> block | default: 0
    * 
    *
    * no order in construct
    */

    /**
	 * Validates a field is not null and not blank.
     */
    static $validates_presence_of = array(
        array('email', 'message' => 'This cant be blank!'),
        array('full_name', 'message' => 'This cant be blank!'),
        array('username', 'message' => 'This cant be blank!'),
        array('pass', 'message' => 'This cant be blank!'),
        array('birthday', 'message' => 'This cant be blank!')
    );


    /**
	 * Validates the uniqueness of a value.
     */
    static $validates_uniqueness_of = array(
        array(array('username'), 'message' => 'The username already exists!'),
        array(array('email'), 'message' => 'The email already exists!')
    );

    /**
	 * Validates the email
	 */
    static $validates_format_of = array(
        array('email', 'with' => '/^.*?@.*$/','message' => 'Invalid email')
    );
    /**
	 * Validates the length of a values
	 */
    static $validates_length_of = array(
        array('username', 'within' => array(1,30)),
        array('full_name', 'within' => array(1,60)),
        array('pass','minimum' => 3),
        array('email', 'within' => array(1,45))
    );
}

?>