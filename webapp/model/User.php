<?php

class User extends \ActiveRecord\Model
{
    private $username;
    private $name;
    
    static $validates_presence_of = array(
        array('name'),
        array('isbn', 'message' => 'YooaaH it must be provided')
    );

    static $validates_presence_of = array(
        array('first_name'),
        array('last_name')
    );
}

?>