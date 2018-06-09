<?php

class UserMovement extends \ActiveRecord\Model
{

    static $table_name = "usersmovements";

    /*
    * id_user         int
    * money_type      String(3)   pay | bet | win | sur
    * credito         int         default: null
    * movement_date   DATETIME    default: CURRENT_TIMESTAMP -> no need to send this field to the db
    * description     String(35)  Carregamento XXX€ | Bet | Win | Sur
    * debito          int         default: null
    * saldo           int
    *
    */
}

?>