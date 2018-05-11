<?php

class User extends \ActiveRecord\Model
{

    static $validates_presence_of = array(
        array('email', 'message' => 'Deverá preencher este campo!'),
        array('full_name', 'message' => 'Deverá preencher este campo!'),
        array('username', 'message' => 'Deverá preencher este campo!'),
        array('pass', 'message' => 'Deverá preencher este campo!'),
        array('birthday', 'message' => 'Deverá preencher este campo!')
    );
}

?>